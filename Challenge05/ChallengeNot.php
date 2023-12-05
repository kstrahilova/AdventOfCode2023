<?php

Challenge::main();

class Challenge
{
    function processMapping(string $line, array $sourceArray, array $destArray): array
    {
        list($destStart, $sourceStart, $range) = explode(' ', trim($line));
        $destStart = (int) $destStart;
        // $destEnd = $destStart = $range - 1;
        $sourceStart = (int) $sourceStart;
        $sourceEnd = $sourceStart + $range - 1;
        $range = (int) $range;

        foreach ($sourceArray as $source) {
            if ($sourceStart <= $source && $source <= $sourceEnd) {
                $sourceIndex = array_search($source, $sourceArray);
                $dest = $destStart + $source - $sourceStart;
                $destArray[$sourceIndex] = $dest;
                // echo "Map " . $source . " -> " . $dest . PHP_EOL;
            }
        }


        foreach ($sourceArray as $index => $element) {
            if (!array_key_exists($index, $destArray)) {
                $destArray[$index] = $element;
                // echo "Not present, Map " . $element . " -> " . $element . PHP_EOL;
            }
        }
        return $destArray;

    }

    function main()
    {
        $lines = file(__DIR__ . "/testInput.txt");
        // $lines = file(__DIR__ . "/input.txt");
        $result = 0;
        $seeds = explode(' ', trim(explode(':', $lines[0])[1]));

        $previous = 1;
        for ($i = 2; $i < count($lines); $i++) {
            // echo $i . " ";
            if (trim($lines[$i]) == "") {
                $offset = ($previous + 2);
                $length = ($i - ($previous + 2));
                // echo $offset . " " . $length . PHP_EOL;
                $input[] = array_slice($lines, $offset, $length);
                $previous = $i;
            }

        }

        $source = [];
        $dest = [];
        for ($i = count($input) - 1; $i >= 0; $i--) {
            if (isset($locations)) {
                // echo $minLocation . " " . $humiditiy . " " . $locationRange . PHP_EOL;
                // $input[]

                for ($j = 0; $j < count($input[$i]); $j++) {
                    $dest = Challenge::processMapping($input[$i][$j], $source, $dest);
                }

                for ($j = 0; $j < count($input[$i]); $j++) {
                    $source[$j] = $dest[$j];
                }

                $dest = [];
            } else {
                $minLocation = PHP_INT_MAX;
                foreach ($input[$i] as $line) {
                    // echo $line . PHP_EOL;
                    $line = explode(" ", trim($line));
                    if ($line[0] < $minLocation) {
                        $minLocation = $line[0];
                        $humiditiy = $line[1];
                        $locationRange = $line[2];
                        for ($j = $minLocation; $j < $locationRange + $minLocation; $j++) {
                            $locations[] = $j;
                            $source[] = $j;
                        }

                    }
                }
            }

        }

        $minLocation = PHP_INT_MAX;

        for ($i = 0; $i < count($source); $i++) {
            for ($j = 0; $j < count($seeds); $j = $j + 2) {
                if ($seeds[$j] <= $source[$i] && $source[$i] <= ($seeds[$j] + $seeds[$j + 1]) && $locations[$i] < $minLocation) {
                    echo "here, i = " . $i . " source = " . $source[$i] . " locations = " . $locations[$i] .  "\n";
                    $minLocation = $locations[$i];
                }
            }
        }
        $result = $minLocation;

        echo ("Result: " . $result . "\n");
    }

}
