<?php

Challenge::main();

class Challenge
{
    function processString(string $line)
    {
        echo ($line);
    }

    function main()
    {
        $input = file(__DIR__ . "/input.txt");
        $result = 0;

        foreach ($input as $line) {
            Challenge::processString($line);
        }

        echo ("Result: " . $result . "\n");
    }

}