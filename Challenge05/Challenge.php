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

    function findMinLocation(array $mapping): int
    {
        $min = PHP_INT_MAX;
        foreach ($mapping as $value) {
            if ($value[1] < $min) {
                $min = $value[1];
            }
        }
        return $min;
    }

    function mergeRanges(array $ranges): array
    {
        // $copy = Challenge::getCopyOfSeeds($ranges);
        for ($i = 0; $i < count($ranges); $i++) {
            if (!isset($ranges[$i])) {
                unset($ranges[$i]);
            } else {
                for ($j = 0; $j < count($ranges); $j++) {
                    if (!isset($ranges[$j])) {
                        unset($ranges[$j]);
                    } else {
                        if ($ranges[$i][0] == $ranges[$j][0] && $ranges[$i][1] == $ranges[$j][1] && $i !== $j) {
                            // $newRange = [$ranges[$i][0], $ranges[$j][1]];
                            // unset($copy[$i]);
                            // unset($ranges[$j]);
                            // $ranges[] = $newRange;
                            // $copy[] = $newRange;
                            echo "Can merge [" . $ranges[$i][0] . ", " . $ranges[$i][1] . "] and [" . $ranges[$j][0] . ", " . $ranges[$j][1] . "]" . PHP_EOL;
                        }
                    }
                }
            }
        }
        return $ranges;
    }

    function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
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
                // echo "\n" . $firstWord . PHP_EOL;
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
                // echo "\n" . $firstWord . PHP_EOL;
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
                // echo "\n" . $firstWord . PHP_EOL;
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
                // echo "\n" . $firstWord . PHP_EOL;
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
                // echo "\n" . $firstWord . PHP_EOL;
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
                // echo "\n" . $firstWord . PHP_EOL;
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
                // echo "\n" . $firstWord . PHP_EOL;
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
        foreach ($seedRanges as $seed) {
            echo "[" . $seed[0] . ", " . $seed[1] . "] \n";
        }
        // return;

        $processing = 1;
        echo count($nonSeeds) . "\n";
        foreach ($nonSeeds as $array) {
            echo "Processing array " . $processing . " out of " . count($nonSeeds) . PHP_EOL;
            $processing += 1;
            $seeds = Challenge::getCopyOfSeeds($seedRanges);
            $initialSizeOfSeeds = count($seeds);
            echo "Seeds is of size " . $initialSizeOfSeeds . PHP_EOL;
            for ($i = 0; $i < count($seeds); $i++) {
            // for ($i = 0; $i < $initialSizeOfSeeds; $i++) {
                // if ($i > $initialSizeOfSeeds) {
                //     echo " i = " . $i . PHP_EOL;
                //     return;
                // }
                $seedRange = $seeds[$i];
                foreach ($array as $range) {
                    $seedStart = $seedRange[0];
                    $seedEnd = $seedRange[1];
                    // if there is no overlap (i.e. this seed range is completely before or after this soil range)
                    if ($seedEnd < $range[0][0] || $seedStart > $range[0][1]) {
                        // do nothing
                        // echo "not contained \n";
                        continue;
                    // } else if ($seedStart <= $range[0][0] && $range[0][1] <= $seedEnd) {
                    } else if ($seedStart < $range[0][0] && $range[0][1] < $seedEnd) {
                        // if array range is completely contained in seed range
                        // split up seed range in three: start - not contained, middle - contained, end - not contained
                        // overwrite contained middle of seeds with complete array range

                        // echo "seed fully contains range old start " . $seedStart . " old end " . $seedEnd . "\n";

                        unset($seeds[$i]);
                        if ($seedStart !== $range[0][0]) {
                            $seeds[] = [$seedStart, $range[1][0] - 1];
                        }

                        $seeds[] = $range[1];

                        if ($seedEnd !== $range[0][1]) {
                            $seeds[] = [$range[1][1] + 1, $seedEnd];
                        }


                    // } else if ($range[0][0] <= $seedStart && $seedEnd <= $range[0][1]) {
                    } else if ($range[0][0] < $seedStart && $seedEnd < $range[0][1]) {
                        // if seed range is completely contained in array range
                        // split up array range in three: start - not contained, middle - contained, end - not contained
                        // overwrite complete seeds with contained middle of array range
                        // echo "range fully contains seed  old start " . $seedStart . " old end " . $seedEnd . " range start " . $range[0][0] . " range end " . $range[0][1] . " ";
                        $differenceStart = $seedStart - $range[0][0];
                        $startSeed = $range[1][0] + $differenceStart;
                        $differenceEnd = $range[0][1] - $seedEnd;
                        $endSeed = $range[1][1] - $differenceEnd;
                        // echo "new start " . $startSeed ." new end ". $endSeed ."\n";
                        $seeds[$i] = [$startSeed, $endSeed];



                    // } else if ($range[0][1] <= $seedEnd) {
                    } else if ($range[0][1] < $seedEnd) {
                        // array range starts before seed range but there's partial overlap
                        // split up array range in two - not contained and contained, and seeds in two - contained and not contained
                        // overwrite contained seeds with contained array
                        // echo "Range starts before seed \n";
                        $differenceStartArray = $seedStart - $range[0][0];
                        $startArray = $range[1][0] + $differenceStartArray;
                        $endArray = $range[1][1];
                        $startSeed = $seedStart + $range[0][1];
                        $endSeed = $seedEnd;

                        $seedOne = [$startArray, $endArray];
                        $seedTwo = [$startSeed, $endSeed];

                        unset($seeds[$i]);
                        $seeds[] = $seedOne;
                        $seeds[] = $seedTwo;

                    // } else {
                    } else if ($range[0][1] > $seedEnd) {
                        // seed range starts before array range but there's partial overlap
                        // split up seeds in two - not contained and contained, and array in two - contained and not contained
                        // overwrite contained seeds with contained array
                        // echo "Seed starts before range \n";
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
                    // foreach ($seeds as $el) {
                    //     echo "[ " . $el[0] . ", " . $el[1] . " ]" . PHP_EOL;
                    // }
                    // echo "Size is " . count($seeds) . PHP_EOL;
                }
            }
            $seeds = Challenge::mergeRanges($seeds);
            $seedRanges = Challenge::getCopyOfSeeds($seeds);
            // foreach ($seedRanges as $el) {
            //     echo "[ " . $el[0] . ", " . $el[1] . " ]" . PHP_EOL;
            // }
            // echo "\n";
        }
        // $test = Challenge::getCopyOfSeeds($seedRanges);



        // $result = min($location);
        foreach ($seedRanges as $el) {
            echo "[ " . $el[0] . ", " . $el[1] . " ]" . PHP_EOL;
        }

        // foreach ($soilRanges as $el) {
        //     echo "[ " . $el[0][0] . ", " . $el[0][1] . " ], [ " . $el[1][0] . ", " . $el[1][1] . " ]" . PHP_EOL;
        // }
        $result = Challenge::findMinLocation($seedRanges);
        echo ("Result: " . $result . "\n");
    }

}
