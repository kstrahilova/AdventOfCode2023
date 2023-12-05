<?php

Challenge::main();

class Challenge
{
    function processMapping(string $line, array $mapping): array
    {
        list($destStart, $sourceStart, $range) = explode(' ', $line);
        $destStart = (int) $destStart;
        $sourceStart = (int) $sourceStart;
        $range = (int) $range;
        // echo 'Source start is ', $sourceStart, ' dest start is ', $destStart, " range is ", $range, PHP_EOL;
        echo $destStart, " ", $sourceStart, " ", $range, PHP_EOL;

        // for ($i = 0; $i < $range; $i++) {
        //     $source = $sourceStart + $i;
        //     $dest = $destStart + $i;
        //     if (in_array($source, $mapping)) {
        //         echo 'Source is ', $source, ' dest is ', $dest, PHP_EOL;
        //         if (array_count_values($mapping)[$source] > 1) {
        //             echo "Issue " . PHP_EOL;
        //         }
        //         $oldSource = array_search($source, $mapping);
        //         unset($mapping[$oldSource]);
        //         $mapping[$source] = $dest;
        //         echo "Old mapping " . $oldSource . " -> " . $source . " becomes " . $source . " -> " . $dest . PHP_EOL;
        //     }

        // }

        for ($i = $range - 1; $i >= 0; $i--) {
            $source = $sourceStart + $i;
            $dest = $destStart + $i;
            if (in_array($source, $mapping)) {
                // echo 'Source is ', $source, ' dest is ', $dest, PHP_EOL;
                // if (array_count_values($mapping)[$source] > 1) {
                //     echo "Issue " . PHP_EOL;
                // }
                $oldSource = array_search($source, $mapping);
                unset($mapping[$oldSource]);
                $mapping[$source] = $dest;
                echo "Old mapping " . $oldSource . " -> " . $source . " becomes " . $source . " -> " . $dest . PHP_EOL;
            }

        }
        return $mapping;

    }

    function main()
    {
        $input = file(__DIR__ . "/testInput.txt");
        // $input = file(__DIR__ . "/input.txt");
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
                    $mapping[$seed] = $seed;
                }
            } else if (in_array($firstWord, $words)) {
                echo "\n" . $firstWord . PHP_EOL;
                $i += 1;
                $line = trim($input[$i]);
                while ($line !== "") {
                    // echo " test " . PHP_EOL;
                    $mapping = Challenge::processMapping($line, $mapping);

                    if ($i < count($input) - 1) {
                        $i += 1;
                        $line = trim($input[$i]);
                    } else {
                        break;
                    }
                }
            }
        }

        $result = min($mapping);

        echo ("Result: " . $result . "\n");
    }

}

class Seed {
    private int $id;
    private int $soil;
    private int $fertilizer;
    private int $water;
    private int $light;
    private int $temperature;
    private int $humidity;
    private int $location;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function setSoil(int $soil) {
        $this->soil = $soil;
    }

    public function getSoil(): int {
        return $this->soil;
    }

    public function setFertilizer(int $fertilizer) {
        $this->fertilizer = $fertilizer;
    }

    public function getFertilizer(): int {
        return $this->fertilizer;
    }

    public function setWater(int $water) {
        $this->water = $water;
    }

    public function getWater(): int {
        return $this->water;
    }

    public function setLight(int $light) {
        $this->light = $light;
    }

    public function getLight(): int {
        return $this->light;
    }

    public function setTemperature(int $temperature) {
        $this->temperature = $temperature;
    }

    public function getTemperature(): int {
        return $this->temperature;
    }

    public function setHumidity(int $humidity) {
        $this->humidity = $humidity;
    }

    public function getHumidity(): int {
        return $this->humidity;
    }

    public function setLocation(int $location) {
        $this->location = $location;
    }

    public function getLocation(): int {
        return $this->location;
    }

}