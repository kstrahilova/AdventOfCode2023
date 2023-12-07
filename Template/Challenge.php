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

        foreach ($input as $line) {
            Challenge::processLine($line);
        }

        echo ("Result: " . $result . "\n");
    }

}