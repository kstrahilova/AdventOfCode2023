<?php

Challenge::main();

class Challenge
{
    function isSymbol(string $char): bool
    {
        return !is_numeric($char) && $char !== ".";
    }

    function main()
    {
        $input = file(__DIR__ . "/input.txt");
        // $input = file(__DIR__ . "/testInput.txt");
        $result = 0;

        // Loop over lines
        for ($i = 0; $i < count($input); $i++) {
            $line = str_split($input[$i]);
            // echo "Line is " . $input[$i] . PHP_EOL;
            if (preg_replace("/[^0-9]/", "", $line) == "") {
                continue;
            }
            $number = "";

            //loop within line
            for ($j = 0; $j < count($line); $j++) {
                if (is_numeric($line[$j])) {
                    if ($number == "") {
                        // if number is empty, then this is the first digit
                        $startIndex = ($j > 0) ? $j - 1 : $j;
                        // echo "start index is " . $startIndex . PHP_EOL;
                    }
                    $number .= $line[$j];
                    // Set read digits to . s.t. they don't get counted more than once
                    $line[$j] = '.';

                } else if ($number !== "") {
                    // then we have just read the number and we are at the symbol after it
                    // echo "Number is " . $number . PHP_EOL;
                    $endIndex = ($j < count($line) - 1) ? $j : $j - 1;
                    for ($index = $startIndex; $index <= $endIndex; $index++) {
                        $startRow = ($i > 0) ? $i - 1 : $i;
                        $endRow = ($i < count($input) - 1) ? $i + 1 : $i;

                        for ($k = $startRow; $k <= $endRow; $k++) {

                            $char = trim(str_split($input[$k])[$index]);
                            if ($char !== "" && Challenge::isSymbol($char)) {
                                // echo "Adding " . $number . " char is " . $char . PHP_EOL;
                                $result += (int) $number;
                                $number = '';

                            }
                        }
                    }

                    $number = '';
                }
            }
        }

        echo ("Result: " . $result . "\n");
    }

}