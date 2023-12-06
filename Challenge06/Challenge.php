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

        // $input[0] = preg_replace('/([\s.\',-])\1+/', '$1', $input[0]);
        // $timeArray = explode(" ", trim(explode(':', trim($input[0]))[1]));
        // $input[1] = preg_replace('/([\s.\',-])\1+/', '$1', $input[1]);
        // $recordDistanceArray = explode(" ", trim(explode(':', trim($input[1]))[1]));

        $input[0] = str_replace(" ","", $input[0]);
        $time = trim(explode(':', trim($input[0]))[1]);
        $input[1] = str_replace(" ","", $input[1]);
        $recordDistance = trim(explode(':', trim($input[1]))[1]);

        // for ($i = 0; $i < count($timeArray); $i++) {
        //     $recordDistance = $recordDistanceArray[$i];
        //     $time = $timeArray[$i];
        //     $current = 0;
        //     for ($speed = 1; $speed <= $time; $speed++) {
        //         $distance = $speed * ($time - $speed);
        //         if ($distance > $recordDistance) {
        //             $current += 1;
        //         }
        //     }
        //     $result *= $current;
        // }
        $first = 0;
        $last = 0;
        echo "Time = " . $time . ", record distance = " . $recordDistance . PHP_EOL;
        for ($speed = 0; $speed <= $time; $speed++) {
                $distance = $speed * ($time - $speed);
                if ($distance > $recordDistance) {
                    $first = $speed;
                    echo "record = " . $recordDistance . " < distance = " . $distance . " = " . $speed . " * (" . $time . " - " . $speed . ")" . PHP_EOL;
                    break;
                } 
        }

        for ($speed = $time; $speed >= 0; $speed--) {
                $distance = $speed * ($time - $speed);
                if ($distance > $recordDistance) {
                    $last = $speed;
                    echo "distance = " . $distance . " = " . $speed . " * (" . $time . " - " . $speed . ")" . PHP_EOL;
                    break;
                } 
        }
        echo $first . " " . $last . PHP_EOL;
        $result = $last - $first + 1;

        echo ("Result: " . $result . "\n");
    }

}