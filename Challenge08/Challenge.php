<?php

Challenge::main();

class Challenge
{
    static function processLine(string $line)
    {
        echo ($line);
    }

    static function main()
    {
        $input = file(__DIR__ . "/testInput.txt");
        // $input = file(__DIR__ . "/input.txt");
        $result = 0;
        $firstLocation = "AAA";
        $currentLocation = $firstLocation;
        $lastLocation = "ZZZ";
        $instructions = array_map(fn($instruction) => ($instruction == 'L') ? 0 : 1, str_split(trim($input[0])));
        $instrSize = count($instructions);
        $map = [];

        for ($i = 2; $i < count($input); $i++) {
            $line = explode(" = ", $input[$i]);
            $index = trim($line[0]);
            $line[1] = str_replace(array("(", ")", ","), "", trim($line[1]));
            $coordinates = explode(" ", trim($line[1]));
            $map[$index] = $coordinates;
        }

        $index = 0;

        while ($currentLocation != $lastLocation) {
            $result += 1;
            $instruction = $instructions[$index];
            // echo "Instruction index " . $instruction . "\n";
            // echo "current location " . $currentLocation . "\n";
            $currentLocation = $map[$currentLocation][$instruction];
            $index = ($index + 1) % $instrSize;
        }

        // foreach ($instructions as $instruction) {
        //     echo $instruction . " ";
        // }
        // echo "\n";
        // foreach ($map as $i => $c) {
        //     echo $i . " => (" . $c[0] . ", " . $c[1] . ") \n";
        // }

        // echo $map[$firstLocation][0] . PHP_EOL;
        // $index = $instructions[0];
        // echo $map[$firstLocation][$index] . PHP_EOL;

        echo ("Result: " . $result . "\n");
    }

}