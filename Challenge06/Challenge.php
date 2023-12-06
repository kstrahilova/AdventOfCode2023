<?php

Challenge::main();

class Challenge
{
    function processLine(string $line)
    {
        echo ($line);
    }

    function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        $result = 1;

        $input[0] = preg_replace('/([\s.\',-])\1+/', '$1', $input[0]);
        $timeArray = explode(" ", trim(explode(':', trim($input[0]))[1]));
        $input[1] = preg_replace('/([\s.\',-])\1+/', '$1', $input[1]);
        $recordDistanceArray = explode(" ", trim(explode(':', trim($input[1]))[1]));

        for ($i = 0; $i < count($timeArray); $i++) {
            $recordDistance = $recordDistanceArray[$i];
            $time = $timeArray[$i];
            $current = 0;
            for ($speed = 1; $speed <= $time; $speed++) {
                $distance = $speed * ($time - $speed);
                if ($distance > $recordDistance) {
                    $current += 1;
                }
            }
            $result *= $current;
        }


        echo ("Result: " . $result . "\n");
    }

}