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

    function findMinLocation(array $mapping): int
    {
        $min = PHP_INT_MAX;
        foreach ($mapping as $value) {
            if ($value[0] < $min) {
                $min = $value[0];
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
                // Uncomment this for part one solution
                // $seedRanges = [[2906422699, 2906422699], [6916147, 6916147], [3075226163, 3075226163], [146720986, 146720986], [689152391, 689152391], [244427042, 244427042], [279234546, 279234546], [382175449, 382175449], [1105311711, 1105311711], [2036236, 2036236], [3650753915, 3650753915], [127044950, 127044950], [3994686181, 3994686181], [93904335, 93904335], [1450749684, 1450749684], [123906789, 123906789], [2044765513, 2044765513], [620379445, 620379445], [1609835129, 1609835129], [60050954, 60050954]];
            } else if ($firstWord == "seed-to-soil map") {
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
        }

        // for each mapping
        foreach ($nonSeeds as $maps) {

            // for each range of seeds
            for ($i = 0; $i < count($seedRanges); $i++) {

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

                    } else if ($firstSeed <= $firstMap && $lastMap <= $lastSeed) {
                        // if map range is completely contained in seed range
                        // split up seed range in three: start - not contained, middle - contained, end - not contained
                        // overwrite contained middle of seeds with complete map range

                        if ($firstSeed < $firstMap) {
                            $seedRanges[] = [$firstSeed, $firstMap - 1];
                        }

                        $seedRanges[$i] = [$firstMap + $difference, $lastMap + $difference];

                        if ($lastSeed > $lastMap) {
                            $seedRanges[] = [$lastMap + 1, $lastSeed];
                        }
                        break;

                    } else if ($firstMap <= $firstSeed && $lastSeed <= $lastMap) {
                        // if seed range is completely contained in map range
                        // split up map range in three: start - not contained, middle - contained, end - not contained
                        // overwrite complete seeds with contained middle of map range

                        $seedRanges[$i] = [$firstSeed + $difference, $lastSeed + $difference];
                        break;

                    } else if ($lastMap < $lastSeed) {
                        // map range starts before seed range but there's partial overlap
                        // split up map range in two - not contained and contained, and seeds in two - contained and not contained
                        // overwrite contained seeds with contained map

                        $seedRanges[$i] = [$firstSeed + $difference, $lastMap + $difference];
                        $seedRanges[] = [$lastMap + 1, $lastSeed];
                        break;

                    } else if ($lastMap > $lastSeed) {
                        // seed range starts before map range but there's partial overlap
                        // split up seeds in two - not contained and contained, and map in two - contained and not contained
                        // overwrite contained seeds with contained map

                        $seedRanges[] = [$firstSeed, $firstMap - 1];
                        $seedRanges[$i] = [$firstMap + $difference, $lastSeed + $difference];
                        break;

                    }

                }
            }
        }

        $result = Challenge::findMinLocation($seedRanges);
        echo ("Result: " . $result . "\n");
    }

}
