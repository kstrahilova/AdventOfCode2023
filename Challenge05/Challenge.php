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

    function processLine(string $line): array
    {
        list($destStart, $sourceStart, $range) = explode(' ', $line);
        $destStart = (int) $destStart;
        $destEnd = $destStart + $range - 1;
        $sourceStart = (int) $sourceStart;
        $sourceEnd = $sourceStart + $range - 1;
        // echo $sourceStart . " " . $sourceEnd . " " . $destStart . " " . $destEnd . PHP_EOL;
        $result = [[$sourceStart, $sourceEnd], [$destStart, $destEnd]];
        return $result;
    }

    function getCopyOfSeeds(array $seeds): array
    {
        $result = [];
        foreach ($seeds as $seed) {
            $result[] = [$seed[0], $seed[1]];
        }
        return $result;
    }

    function main()
    {
        $input = file(__DIR__ . "/testInput.txt");
        // $input = file(__DIR__ . "/input.txt");
        $result = 0;
        $nonSeeds = [];

        for ($i = 0; $i < count($input); $i++) {
            $line = trim($input[$i]);
            $exploded = explode(':', $line);
            $firstWord = trim($exploded[0]);
            if ($firstWord == 'seeds') {
                $seedsInput = explode(' ', trim($exploded[1]));
                $seedRanges = [];
                for ($j = 0; $j < count($seedsInput) - 1; $j = $j + 2) {
                    $seedRanges[] = [$seedsInput[$j], ($seedsInput[$j] + $seedsInput[$j + 1] - 1)];
                }
            } else if ($firstWord == "seed-to-soil map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $soilRanges = [];
                while ($line !== "") {
                    $soilRanges[] = Challenge::processLine($line);
                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $soilRanges;

            } else if ($firstWord == "soil-to-fertilizer map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $fertRanges = [];
                while ($line !== "") {
                    $fertRanges[] = Challenge::processLine($line);
                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $fertRanges;
            } else if ($firstWord == "fertilizer-to-water map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $waterRanges = [];
                while ($line !== "") {
                    $waterRanges[] = Challenge::processLine($line);
                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $waterRanges;
            } else if ($firstWord == "water-to-light map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $lightRanges = [];
                while ($line !== "") {
                    $lightRanges[] = Challenge::processLine($line);
                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $lightRanges;
            } else if ($firstWord == "light-to-temperature map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $tempRanges = [];
                while ($line !== "") {
                    $tempRanges[] = Challenge::processLine($line);

                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $tempRanges;
            } else if ($firstWord == "temperature-to-humidity map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $humidityRanges = [];
                while ($line !== "") {
                    $humidityRanges[] = Challenge::processLine($line);

                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $humidityRanges;
            } else if ($firstWord == "humidity-to-location map") {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                $locationRanges = [];
                while ($line !== "") {
                    $locationRanges[] = Challenge::processLine($line);

                    $i += 1;
                    $line = trim($input[$i]);
                }
                $nonSeeds[] = $locationRanges;
            }
            // echo "here";
        }

        foreach ($nonSeeds as $array) {
            $seeds = Challenge::getCopyOfSeeds($seedRanges);
            for ($i = 0; $i < count($seeds); $i++) {
                $seedRange = $seeds[$i];
                foreach ($array as $range) {
                    $source = $range[0];
                    $seedStart = $seedRange[0];
                    $seedEnd = $seedRange[1];
                    // if there is no overlap (i.e. this seed range is completely before or after this soil range)
                    if ($seedEnd < $range[0][0] || $seedStart > $range[0][1]) {
                        // do nothing
                        continue;
                    } else if ($seedStart <= $range[0][0] && $range[0][1] <= $seedEnd) {
                        // if array range is completely contained in seed range
                        // split up seed range in three: start - not contained, middle - contained, end - not contained
                        // overwrite contained middle of seeds with complete array range
                        $seedOne = ($seedStart == $range[0][0]) ? [] : [$seedStart, $range[1][0] - 1];
                        $seedTwo = $range[0];
                        $seedThree = ($seedEnd == $range[0][1]) ? [] : [$range[1][1] + 1, $seedEnd];

                        unset($seeds[$i]);
                        $seeds[] = $seedOne;
                        $seeds[] = $seedTwo;
                        $seeds[] = $seedThree;


                    } else if ($range[0][0] <= $seedStart && $seedEnd <= $range[0][1]) {
                        // if seed range is completely contained in array range
                        // split up array range in three: start - not contained, middle - contained, end - not contained
                        // overwrite complete seeds with contained middle of array range
                        $differenceStart = $seedStart - $range[0][0];
                        $differenceEnd = $range[0][1] - $seedEnd;
                        $range = [$range[1][0] + $differenceStart, $range[1][0] - $differenceEnd];
                        $seeds[$i] = $range;


                    } else if ($range[0][1] <= $seedEnd) {
                        // array range starts before seed range but there's partial overlap
                        // split up array range in two - not contained and contained, and seeds in two - contained and not contained
                        // overwrite contained seeds with contained array
                        $differenceStartArray = $seedStart - $range[0][0];
                        $startArray = $range[1][0] + $differenceStartArray;
                        $endArray = $range[1][1];
                        $startSeed = $seedStart + $array[0][1];
                        $endSeed = $seedEnd;

                        $seedOne = [$startArray, $endArray];
                        $seedTwo = [$startSeed, $endSeed];

                        unset($seeds[$i]);
                        $seeds[] = $seedOne;
                        $seeds[] = $seedTwo;

                    } else {
                        // seed range starts before array range but there's partial overlap
                        // split up seeds in two - not contained and contained, and array in two - contained and not contained
                        // overwrite contained seeds with contained array
                        $startSeed = $seedStart;
                        $endSeed = $seedEnd;
                        $startArray = $range[1][0];
                        $differenceEndArray = $range[0][1] - $seedEnd;
                        $endArray = $range[1][1] - $differenceEndArray;

                        $seedOne = [$startSeed, $endSeed];
                        $seedTwo = [$startArray, $endArray];

                        unset($seeds[$i]);
                        $seeds[] = $seedOne;
                        $seeds[] = $seedTwo;

                    }
                    echo "Size is " . count($seeds) . PHP_EOL;
                }
            }
            $seedRanges = Challenge::getCopyOfSeeds($seeds);
            foreach ($seedRanges as $el) {
                echo "[ " . $el[0] . ", " . $el[1] . " ]" . PHP_EOL;
            }
            echo "\n";
        }
        // $test = Challenge::getCopyOfSeeds($seedRanges);



        // $result = min($location);
        foreach ($seedRanges as $el) {
            echo "[ " . $el[0] . ", " . $el[1] . " ]" . PHP_EOL;
        }

        // foreach ($soilRanges as $el) {
        //     echo "[ " . $el[0][0] . ", " . $el[0][1] . " ], [ " . $el[1][0] . ", " . $el[1][1] . " ]" . PHP_EOL;
        // }
        echo ("Result: " . $result . "\n");
    }

}
