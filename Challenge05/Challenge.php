<?php

Challenge::main();

class Challenge
{
    function processMapping(string $line, array $sourceArray, array $destArray): array
    {
        list($destStart, $sourceStart, $range) = explode(' ', $line);
        $destStart = (int) $destStart;
        $sourceStart = (int) $sourceStart;
        $range = (int) $range;
        // echo 'Source start is ', $sourceStart, ' dest start is ', $destStart, " range is ", $range, PHP_EOL;
        echo $destStart, " ", $sourceStart, " ", $range, PHP_EOL;

        for ($i = $range - 1; $i >= 0; $i--) {
            $source = $sourceStart + $i;
            $dest = $destStart + $i;
            if (in_array($source, $sourceArray)) {
                // echo 'Source is ', $source, ' dest is ', $dest, PHP_EOL;
                // if (array_count_values($mapping)[$source] > 1) {
                //     echo "Issue " . PHP_EOL;
                // }
                $sourceIndex = array_search($source, $sourceArray);
                $destArray[$sourceIndex] = $dest;
                echo "Map " . $source . " -> " . $dest . PHP_EOL;
            }

        }

        foreach ($sourceArray as $index => $element) {
            if (!array_key_exists($index, $destArray)) {
                $destArray[$index] = $element;
            }
        }
        return $destArray;

    }

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
            // echo "First word is " . $firstWord . PHP_EOL;
            if ($firstWord == 'seeds') {
                $seedsInput = explode(' ', trim($exploded[1]));
                foreach ($seedsInput as $seed) {
                    $seeds[] = $seed;
                }
            } else if ($firstWord == "seed-to-soil map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $soil = [];
                while ($line !== "") {
                    // echo " test " . PHP_EOL;
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
                    // echo " test " . PHP_EOL;
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
                    // echo " test " . PHP_EOL;
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
                    // echo " test " . PHP_EOL;
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
                    // echo " test " . PHP_EOL;
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
                    // echo " test " . PHP_EOL;
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
                    // echo " test " . PHP_EOL;
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
