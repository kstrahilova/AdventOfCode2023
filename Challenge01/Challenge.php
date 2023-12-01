<?php

Challenge::main();

class Challenge
{
    static function processLine(
        string $line
    ): int {
        $numbers = [
            "1" => "one",
            "2"=> "two",
            "3"=> "three",
            "4" => "four",
            "5" => "five",
            "6" => "six",
            "7" => "seven",
            "8" => "eight",
            "9" => "nine",
        ];

        foreach ($numbers as $digit => $number) {
            $line = str_replace($number, $number . $digit . $number, $line);
        }

        preg_match_all('!\d!', $line, $line);
            return (int) ($line[0][0] . $line[0][count($line[0]) - 1]);
        
    }

    function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        $result = 0;

        foreach ($input as $line) {
            if (trim($line) !== "") {
                $result += Challenge::processLine($line);
            }
        }

        echo ("Result: " . $result . "\n");
    }

}