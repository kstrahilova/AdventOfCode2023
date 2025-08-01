<?php

Challenge::main();

$output = "";
class Challenge
{
    static function compareArrays(array $a, array $b): bool
    {
        if (count($a) !== count($b)) {
            return false;
        } else {
            for ($i = 0; $i < count($a); $i++) {
                if ($a[$i] !== $b[$i]) {
                    return false;
                }
            }
        }
        return true;
    }
    static function checkPerfect(array $pattern, int $reflection): bool
    {
        for ($i = 0; $i <= count($pattern) - $reflection; $i++) {
            $first = $reflection - 1 - $i;
            $second = $reflection + $i;
            // echo "Reflection ". $reflection . " first index " . $first . " " . $a[$first] . " " . $b[$first] . " second index " . $second . " " . $a[$second] . " " . $b[$second] . PHP_EOL;
            if ($first < 0 || $second >= count($pattern)) {
                return true;
            } else if (!Challenge::compareArrays($pattern[$first], $pattern[$second])) {
                return false;
            }

        }
        return false;
    }
    

    /**
     * @return int #elements different between two arrays
     */
    static function numberOfDifferentElements(array $a, array $b): int
    {
        $current = 0;
        if (count($a) !== count($b)) {
            return PHP_INT_MAX;
        } else {
            for ($i = 0; $i < count($a); $i++) {
                if ($a[$i] !== $b[$i]) {
                    $current += 1;
                }
            }
        }
        return $current;
    }
    static function checkSmudge(array $pattern, int $reflection): bool
    {
        $allowed = 1;
        for ($i = 0; $i <= count($pattern) - $reflection; $i++) {
            $first = $reflection - 1 - $i;
            $second = $reflection + $i;
            echo "Reflection ". $reflection . " first index " . $first . " second index " . $second . PHP_EOL;
            if ($first < 0 || $second >= count($pattern)) {
                return true;
            } else {
                $nDifferentlements = Challenge::numberOfDifferentElements($pattern[$first], $pattern[$second]);
                if ($allowed < $nDifferentlements) {
                    return false;
                } else {
                    $allowed -= $nDifferentlements;
                }
            }

        }
        return true;
    }
    /**
     * @return int - the index below horizontal line  = #rows above horizontal line
     */
    static function findHorizontalLine(array $pattern): int
    {
        for ($i = 0; $i < count($pattern) - 1; $i++) {
            if (Challenge::compareArrays($pattern[$i], $pattern[$i + 1])) {
                // if (Challenge::checkPerfect($pattern, $i + 1)) {
                if (Challenge::checkSmudge($pattern, $i + 1)) {
                    echo "Returning " . ($i + 1) . "\n";
                    return $i + 1;
                }
            }
        }
        return 0;
    }
    static function processPattern(array $pattern): int
    {
        global $output;
        $horisontalLine = Challenge::findHorizontalLine($pattern);
        $verticalLine = 0;
        if ($horisontalLine == 0) {
        // Get transpose to check columns
            $pattern = array_map(null, ...$pattern);
            $verticalLine = Challenge::findHorizontalLine($pattern);
        }

        // foreach ($pattern as $row) {
        //     foreach ($row as $element) {
        //         $output .= $element . " ";
        //     }
        //     $output .= PHP_EOL;
        // }
        // $output .= PHP_EOL;



        return $verticalLine + 100 * $horisontalLine;
    }

    static function main()
    {
        $input = file(__DIR__ . "/testInput.txt");
        // $input = file(__DIR__ . "/input.txt");
        $result = 0;
        global $output;
        $currentPattern = [];

        foreach ($input as $line) {
            if (trim($line) !== "") {
                $currentPattern[] = str_split(trim($line));
            } else {
                $result += Challenge::processPattern($currentPattern);
                $currentPattern = [];
            }
        }

        file_put_contents(__DIR__ . "/output.txt", $output);

        echo ("Result: " . $result . "\n");
    }

}