<?php

Challenge::main();

class Challenge
{
    static function processLine(string $line) : int
    {
        list($winning, $actual) = explode(' | ', trim(explode(': ', trim($line))[1]));
        $winning = explode(' ', $winning);
        array_walk($winning, fn (string $string) => trim($string));
        $actual = explode(' ', $actual);
        array_walk($actual, fn (string $string) => trim($string));
        $matches = 0;
        foreach ($winning as $winningNumber) {
            if (in_array($winningNumber, $actual) && $winningNumber !== "") {
                $matches += 1;
            }
        }

        $result = ($matches > 0) ? 2 ** ($matches - 1) : 0;
        return $result;
    }

    static function main()
    {
        $input = file(__DIR__ . "/input.txt");
        // $input = file(__DIR__ . "/testInput.txt");
        $result = 0;

        foreach ($input as $line) {
            $result += Challenge::processLine($line);
        }

        echo ("Result: " . $result . "\n");
    }

}