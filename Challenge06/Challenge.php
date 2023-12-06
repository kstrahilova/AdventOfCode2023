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

        // $part = 1;
        $part = 2;

        $first = 0;
        $last = 0;

        if ($part == 1) {
            $input[0] = preg_replace('/([\s.\',-])\1+/', '$1', $input[0]);
            $timeArray = explode(" ", trim(explode(':', trim($input[0]))[1]));
            $input[1] = preg_replace('/([\s.\',-])\1+/', '$1', $input[1]);
            $recordDistanceArray = explode(" ", trim(explode(':', trim($input[1]))[1]));
        } else {
            $input[0] = str_replace(" ", "", $input[0]);
            $timeArray = [trim(explode(':', trim($input[0]))[1])];
            $input[1] = str_replace(" ", "", $input[1]);
            $recordDistanceArray = [trim(explode(':', trim($input[1]))[1])];
        }

        for ($i = 0; $i < count($timeArray); $i++) {
            $recordDistance = $recordDistanceArray[$i];
            $time = $timeArray[$i];
            echo "Time = " . $time . ", record distance = " . $recordDistance . PHP_EOL;
            for ($speed = 0; $speed <= $time; $speed++) {
                $distance = $speed * ($time - $speed);
                if ($distance > $recordDistance) {
                    $first = $speed;
                    break;
                }
            }

            for ($speed = $time; $speed >= 0; $speed--) {
                $distance = $speed * ($time - $speed);
                if ($distance > $recordDistance) {
                    $last = $speed;
                    break;
                }
            }

            echo $first . " " . $last . PHP_EOL;
            $result *= ($last - $first + 1);
        }

        echo ("Result: " . $result . "\n");
    }

}