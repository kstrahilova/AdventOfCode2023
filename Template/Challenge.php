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
        $output = "";

        foreach ($input as $line) {
            Challenge::processLine($line);
        }

        file_put_contents(__DIR__ . "/output.txt", $output);

        echo ("Result: " . $result . "\n");
    }

}