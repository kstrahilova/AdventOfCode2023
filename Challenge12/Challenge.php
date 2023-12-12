<?php

Challenge::main();

class Challenge
{
    static $output = "";
    /**
     * @input $springs - array of groups of springs that have no
     */
    static function processLine(array $springGroups, array $sizeOfDamagedGroups): int
    {
        $arrangements = 0;
        global $output;

        $output .= "\nRunning method\n";
        // Base cases
        // Either we have processed all damaged groups
        if (count($sizeOfDamagedGroups) == 0 || (count($sizeOfDamagedGroups) == 1 && $sizeOfDamagedGroups[0] == 0)) {
            $output .= "We have processed all damaged groups\n";
            return 1;
        }

        // or we have not but we have run out of springs
        if (count($springGroups) == 0) {
            $output .= "We have run out of springs\n";
            return 0;
        }

        // Step

        // Get first group
        $currentSpringGroup = $springGroups[0];
        // Get first # group size
        $currentDamagedGroupSize = $sizeOfDamagedGroups[0];

        if (count($currentSpringGroup) == $currentDamagedGroupSize) {
            // If the current group and the current damagedGroupSize are equal
            $output .= "Equal \n";
            //      we can either set all to #, continuing without the first group and first group size
            $output .= "Setting all of this group to #\n";
            $groupsWithoutFirst = $springGroups;
            array_shift($groupsWithoutFirst);
            $sizesWithoutFirst = $sizeOfDamagedGroups;
            array_shift($sizesWithoutFirst);
            $arrangements += Challenge::processLine($groupsWithoutFirst, $sizesWithoutFirst);

            //      or if there are no #'s in the group, set all to ., continuing with one less group and same sizes
            if (!in_array('#', $springGroups[0])) {
                $output .= "There are no #'s in this group, setting all of this group to .\n";
                $groupsWithoutFirst = $springGroups;
                array_shift($groupsWithoutFirst);
                $arrangements += Challenge::processLine($groupsWithoutFirst, $sizeOfDamagedGroups);
            }

        } else if (count($currentSpringGroup) > $currentDamagedGroupSize) {
            // If the current group is larger than the current damagedGroupSize, we can:
            $output .= "Group is larger than group size \n";
            //      if the $currentDamagedGroupSize + 1'th element is .
            //      set $currentDamagedGroupSize elements to # followed by one ., continue with removing that many elements + 1 from current group and current size from sizes
            $output .= $currentDamagedGroupSize . "\n";
            $output .= $springGroups[0][$currentDamagedGroupSize] . "\n";
            if (count($springGroups[0]) >= $currentDamagedGroupSize + 1 && $springGroups[0][$currentDamagedGroupSize] == '?') {

                $output .= "We set |size| elements to # followed by ., remove |size| + 1 elements from groups and remove size from sizes\n";
                $groupsWithoutElementsFromFirstGroup = $springGroups;
                array_splice($groupsWithoutElementsFromFirstGroup[0], 0, $sizeOfDamagedGroups[0] + 1);

                $sizesWithoutFirst = $sizeOfDamagedGroups;
                array_shift($sizesWithoutFirst);
                $arrangements += Challenge::processLine($groupsWithoutElementsFromFirstGroup, $sizesWithoutFirst);
            }

            //      if the first element is ?, set it to ., continuing with one less element in group and the same sizes
            if ($springGroups[0][0] == '?') {
                $output .= "The first element of group is ?, we set it to ., remove one element from group and continue\n";
                $groupsWithoutFirstElementOfFirstGroup = $springGroups;
                array_shift($groupsWithoutFirstElementOfFirstGroup[0]);
                $arrangements += Challenge::processLine($groupsWithoutFirstElementOfFirstGroup, $sizeOfDamagedGroups);
            }

        } else if (count($currentSpringGroup) < $currentDamagedGroupSize) {
            // Else the current group is smaller than the current damagedGroupSize, then:
            $output .= "Group is smaller than size\n";
            //      if there is a # in the group we add 0 and stop processing this arrangement
            //      if not, we set all ?'s to . and continue with one less group and the same damaged group sizes
            if (!in_array('#', $springGroups[0])) {
                $output .= "There are no #'s in group, we set all ?'s to ., remove group from groups and continue with same sizes\n";
                $groupsWithoutFirst = $springGroups;
                array_shift($groupsWithoutFirst);
                $arrangements += Challenge::processLine($groupsWithoutFirst, $sizeOfDamagedGroups);
            }
        } else {
            $output .= "ERROR\n";
        }

        $output .= "We are returning " . $arrangements . "\n";
        return $arrangements;

    }

    static function main()
    {
        $input = file(__DIR__ . "/testInput.txt");
        // $input = file(__DIR__ . "/input.txt");
        $result = 0;
        global $output;

        foreach ($input as $line) {
            $line = explode(" ", trim($line));
            $springs = array_map(fn(string $element) => str_split($element), array_values(array_filter(explode(".", trim($line[0])))));
            // print_r($springs);
            $damaged = explode(",", trim($line[1]));
            // print_r($damaged);
            $result += Challenge::processLine($springs, $damaged);
        }
        // $line = $input[5];

        // $line = explode(" ", trim($line));
        // $springs = array_map(fn(string $element) => str_split($element), array_values(array_filter(explode(".", trim($line[0])))));
        // print_r($springs);
        // $damaged = explode(",", trim($line[1]));
        // print_r($damaged);
        // $result += Challenge::processLine($springs, $damaged);

        // $test = [['?', '?', '?'], ['#', '#', '#']];
        // $test = [[0]];
        // $shifted = array_shift($test);
        // echo $shifted . PHP_EOL;
        // print_r($shifted);
        // print_r($test);
        // echo(count($test)==0);

        file_put_contents(__DIR__ . "/output.txt", $output);

        echo ("Result: " . $result . "\n");
    }

}