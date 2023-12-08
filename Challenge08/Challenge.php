<?php

Challenge::main();

class Challenge
{
    static function processLine(string $line)
    {
        echo ($line);
    }

    static function gcd(int $a, int $b)
    {
        while ($b !== 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }

        return $a;
    }

    static function lcm(int $a, int $b)
    {
        return $a * $b / Challenge::gcd($a, $b);
    }

    static function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        $part = 2;

        // Part 1
        $firstLocation = "AAA";
        $currentLocation = $firstLocation;
        $lastLocation = "ZZZ";

        // Part 2
        $firstLocations = [];

        $instructions = array_map(fn($instruction) => ($instruction == 'L') ? 0 : 1, str_split(trim($input[0])));
        $instrSize = count($instructions);
        $map = [];

        for ($i = 2; $i < count($input); $i++) {
            $line = explode(" = ", $input[$i]);
            $index = trim($line[0]);
            $line[1] = str_replace(array("(", ")", ","), "", trim($line[1]));
            $coordinates = explode(" ", trim($line[1]));
            $map[$index] = $coordinates;

            if ($part == 2 && str_split($index)[2] == 'A') {
                $firstLocations[] = $index;
            }
        }

        $index = 0;

        if ($part == 1) {
            $result = 0;
            while ($currentLocation != $lastLocation) {
                $result += 1;
                $instruction = $instructions[$index];
                $currentLocation = $map[$currentLocation][$instruction];
                $index = ($index + 1) % $instrSize;
            }

        } else {
            for ($loc = 0; $loc < count($firstLocations); $loc++) {
                $currentLocation = $firstLocations[$loc];
                $path = 0;
                while (str_split($currentLocation)[2] !== 'Z') {
                    $path += 1;
                    $instruction = $instructions[$index];
                    $currentLocation = $map[$currentLocation][$instruction];
                    $index = ($index + 1) % $instrSize;
                }
                $paths[] = $path;
            }

            foreach ($paths as $path) {
                if (!isset($result)) {
                    $result = $path;
                } else {
                    $result = Challenge::lcm($result, $path);
                }
            }

        }

        echo ("Result: " . $result . "\n");
    }

}