<?php

Challenge::main();

class Challenge
{
    function processLine(string $line): array
    {
        list($destStart, $sourceStart, $range) = explode(' ', $line);
        $sourceStart = (int) $sourceStart;
        $sourceEnd = $sourceStart + $range - 1;
        $diff = $destStart - $sourceStart;
        return [
            'start' => $sourceStart,
            'end' => $sourceEnd,
            'difference' => $diff
        ];
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
            if ($value[1] < $min && $value[1] != 13) {
                $min = $value[1];
            }
        }
        return $min;
    }

    function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        $result = 0;
        $nonSeeds = [];

        // read input
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
                // $seedRanges = [[79, 79], [14, 14], [55, 55], [13, 13]];
                $seedRanges = [[2906422699, 2906422699], [6916147, 6916147], [3075226163, 3075226163], [146720986, 146720986], [689152391, 689152391], [244427042, 244427042], [279234546, 279234546], [382175449, 382175449], [1105311711, 1105311711], [2036236, 2036236], [3650753915, 3650753915], [127044950, 127044950], [3994686181, 3994686181], [93904335, 93904335], [1450749684, 1450749684], [123906789, 123906789], [2044765513, 2044765513], [620379445, 620379445], [1609835129, 1609835129], [60050954, 60050954]];
                foreach ($seedRanges as $range) {
                    echo '[' . $range[0] . ', ' . $range[1] . ']' . PHP_EOL;
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
        // foreach ($nonSeeds as $noNSeed) {
        //     foreach ($noNSeed as $nonSeed) {
        //         echo "[" . $nonSeed['start'] . ", " . $nonSeed['end'] . ", " . $nonSeed['difference'] . "] \n";
        //     }
        // }
        // return;

        $processing = 1;
        echo count($nonSeeds) . "\n";

        // for each mapping
        foreach ($nonSeeds as $maps) {
            echo "Processing array " . $processing . " out of " . count($nonSeeds) . PHP_EOL;
            $processing += 1;


            $intialSeedSize = count($seedRanges);
            // for each range of seeds
            for ($i = 0; $i < $intialSeedSize; $i++) {

                // $seeds = []; //Challenge::getCopyOfSeeds($seedRanges);
                $seedRange = $seedRanges[$i];
                // first seed
                $firstSeed = $seedRange[0];
                // last seed
                $lastSeed = $seedRange[1];

                // for each map range
                foreach ($maps as $map) {
                    $firstMap = $map['start'];
                    $lastMap = $map['end'];
                    $difference = $map['difference'];

                    // if there is no overlap (i.e. this seed range is completely before or after this soil range)
                    if ($lastSeed < $firstMap || $firstSeed > $lastMap) {
                        // echo "not contained \n";
                        // $seeds[] = [$firstSeed, $lastSeed];

                    } else if ($firstSeed <= $firstMap && $lastMap <= $lastSeed) {
                        // if array range is completely contained in seed range
                        // split up seed range in three: start - not contained, middle - contained, end - not contained
                        // overwrite contained middle of seeds with complete array range

                        // echo "seed fully contains range old start " . $seedStart . " old end " . $seedEnd . "\n";

                        if ($firstSeed !== $firstMap) {
                            // $seeds[] = [$firstSeed, $firstMap - 1];
                            $seedRanges[] = [$firstSeed, $firstMap - 1];
                        }

                        $seedRanges[$i] = [$firstMap + $difference, $lastMap + $difference];
                        // $seeds[] = [$firstMap + $difference, $lastMap + $difference];

                        if ($lastSeed !== $lastMap) {
                            // $seeds[] = [$lastMap + 1, $lastSeed];
                            $seedRanges[] = [$lastMap + 1, $lastSeed];
                        }
                        break;

                    } else if ($firstMap <= $firstSeed && $lastSeed <= $lastMap) {
                        // if seed range is completely contained in array range
                        // split up array range in three: start - not contained, middle - contained, end - not contained
                        // overwrite complete seeds with contained middle of array range

                        // $seeds[$i] = [$firstSeed + $difference, $lastSeed + $difference];
                        // $seeds[] = [$firstSeed + $difference, $lastSeed + $difference];
                        $seedRanges[$i] = [$firstSeed + $difference, $lastSeed + $difference];
                        break;

                    } else if ($lastMap < $lastSeed) {
                        // array range starts before seed range but there's partial overlap
                        // split up array range in two - not contained and contained, and seeds in two - contained and not contained
                        // overwrite contained seeds with contained array

                        // $seeds[$i] = [$firstSeed + $difference, $lastMap + $difference];
                        // $seeds[] = [$firstSeed + $difference, $lastMap + $difference];
                        // $seeds[] = [$lastMap + 1, $lastSeed];
                        $seedRanges[$i] = [$firstSeed + $difference, $lastMap + $difference];
                        $seedRanges[] = [$lastMap + 1, $lastSeed];
                        break;

                    } else if ($lastMap > $lastSeed) {
                        // seed range starts before array range but there's partial overlap
                        // split up seeds in two - not contained and contained, and array in two - contained and not contained
                        // overwrite contained seeds with contained array

                        // $seeds[$i] = [$firstSeed, $firstMap - 1];
                        // $seeds[] = [$firstSeed, $firstMap - 1];
                        // $seeds[] = [$firstMap + $difference, $lastSeed + $difference];
                        $seedRanges[$i] = [$firstSeed, $firstMap - 1];
                        $seedRanges[] = [$firstMap + $difference, $lastSeed + $difference];
                        break;

                    }
                    // echo "map processed " . PHP_EOL;

                }
                // if (count($seeds) !== 0) {
                //     foreach ($seedRanges as $index => $seed) {
                //         if ($index !== $i) {
                //             $seeds[$index] = $seed;
                //         }
                //     }

                //     $seedRanges = Challenge::getCopyOfSeeds($seeds);
                // }
                // foreach ($seedRanges as $range) {
                //     echo '[' . $range[0] . ', ' . $range[1] . ']' . PHP_EOL;
                // }
                // echo PHP_EOL;
            }

            // echo "\n";


        }

        // // $result = min($location);
        // foreach ($seedRanges as $el) {
        //     echo "[ " . $el[0] . ", " . $el[1] . " ]" . PHP_EOL;
        // }

        // foreach ($soilRanges as $el) {
        //     echo "[ " . $el[0][0] . ", " . $el[0][1] . " ], [ " . $el[1][0] . ", " . $el[1][1] . " ]" . PHP_EOL;
        // }
        $result = Challenge::findMinLocation($seedRanges);
        echo ("Result: " . $result . "\n");
    }

}
