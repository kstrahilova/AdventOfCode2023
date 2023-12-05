<?php

Challenge::main();

class Challenge
{
    function processMapping(string $line, array $sourceArray, array $destArray): array
    {
        list($destStart, $sourceStart, $range) = explode(' ', $line);
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

    // function processSeeds(array $input) : array {
    //     $seeds = [];
    //     for ($i = 0; $i < count($input); $i++) {
    //         $start = $input[$i];
    //         $i += 1;
    //         $range = $input[$i];
    //         for ($j = $start; $j < $range + $start; $j++) {
    //             echo 'j = ', $j,PHP_EOL;
    //             $seeds[] = $j;
    //         }
    //     }
    //     return $seeds;
    // }

    function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        $result = 0;
        $words = [
            "seed-to-soil map",
            "soil-to-fertilizer map",
            "fertilizer-to-water map",
            "water-to-light map",
            "light-to-temperature map",
            "temperature-to-humidity map",
            "humidity-to-location map"
        ];

        for ($i = 0; $i < count($input); $i++) {
            $line = trim($input[$i]);
            $exploded = explode(':', $line);
            $firstWord = trim($exploded[0]);
            if ($firstWord == 'seeds') {
                $seedsInput = explode(' ', trim($exploded[1]));
                foreach ($seedsInput as $seed) {
                    $seeds[] = $seed;
                }
                // $seeds = Challenge::processSeeds($seedsInput);
            } else if ($firstWord == "seed-to-soil map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $soil = [];
                while ($line !== "") {
                    $soil = Challenge::processMapping($line, $seeds, $soil);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            } else if ($firstWord == "soil-to-fertilizer map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $fert = [];
                while ($line !== "") {
                    $fert = Challenge::processMapping($line, $soil, $fert);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            } else if ($firstWord == "fertilizer-to-water map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $water = [];
                while ($line !== "") {
                    $water = Challenge::processMapping($line, $fert, $water);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            } else if ($firstWord == "water-to-light map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $light = [];
                while ($line !== "") {
                    $light = Challenge::processMapping($line, $water, $light);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            } else if ($firstWord == "light-to-temperature map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $temp = [];
                while ($line !== "") {
                    $temp = Challenge::processMapping($line, $light, $temp);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            } else if ($firstWord == "temperature-to-humidity map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $humidity = [];
                while ($line !== "") {
                    $humidity = Challenge::processMapping($line, $temp, $humidity);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            } else if ($firstWord == "humidity-to-location map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $location = [];
                while ($line !== "") {
                    $location = Challenge::processMapping($line, $humidity, $location);

                    $i += 1;
                    $line = trim($input[$i]);
                }
            }
        }

        $result = min($location);

        echo ("Result: " . $result . "\n");
    }

}
