<?php

Challenge::main();

class Challenge
{
    function isSymbol(string $char) {
        return !is_numeric($char) && $char !== ".";
    }

    function processString(string $string) : int {
        echo $string . PHP_EOL;
        
        foreach (str_split($string) as $char) {
            echo $char . PHP_EOL;
            if (Challenge::isSymbol($char)) {
                $number = preg_replace("/[^0-9]/", "", $string);
                return (int) $number;
            }
        }
        
        return 0;
    }

    function processTuple(array $lineOne, array $lineTwo, array $lineThree) : int
    {
        $number = "";
        $result = 0;

        for ($i = 0; $i < count($lineOne); $i++) {
            $index = $i - 1;
            while (is_numeric($lineOne[$i])) {
                $i++;
            }

            while ($index <= $i) {
                // echo "index is " . $index . PHP_EOL;
                if ($index >= 0 && $index < count($lineOne)) {
                    $number .= $lineOne[$index];
                    $number .= $lineTwo[$index];
                }
                $index++;
            }

            $result += Challenge::processString($number);
            $number = "";
            $i = $index;

        }
        return $result;
        
    }

    function main()
    {
        // $input = file(__DIR__ . "/input.txt");
        $input = file(__DIR__ . "/testInput.txt");
        $result = 0;
        $lineOne = str_split(trim($input[0]));
        $lineTwo = str_split(trim($input[1]));
        $lineThree = str_split(trim($input[2]));
        // $line = [$input[0], $input[1], $input[2]];
        $result += Challenge::processTuple($lineOne, $lineTwo, $lineThree);


        // for ($i = 3; $i < count($input); $i++) {

        // }

        echo $input[0];
        echo $input[1];

        echo ("Result: " . $result . "\n");
    }

}