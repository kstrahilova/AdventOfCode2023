<?php

Challenge::main();

class Challenge
{
    function isSymbol(string $char): bool
    {
        return !is_numeric($char) && $char !== ".";
    }

    function getGearNumber(string $line, int $index): array
    {
        $sJ = $index;
        $eJ = $index;
        $firstNumber = "";

        while ($sJ > 0 && is_numeric($line[$sJ - 1])) {
            $sJ--;
        }
        while ($eJ < strlen($line) - 1 && is_numeric($line[$eJ + 1])) {
            $eJ++;
        }
        for ($nJ = $sJ; $nJ <= $eJ; $nJ++) {
            $firstNumber .= $line[$nJ];
            $line[$nJ] = '.';
        }

        return [$firstNumber, $line];
    }

    function partOne(array $input): int
    {

        $result = 0;
        // Loop over lines
        for ($row = 0; $row < count($input); $row++) {
            $line = str_split($input[$row]);

            // if line does not contain any digits, skip it
            if (preg_replace("/[^0-9]/", "", $line) == "") {
                continue;
            }

            $number = "";

            //loop within line
            for ($j = 0; $j < count($line); $j++) {
                // if character is digit
                if (is_numeric($line[$j])) {
                    if ($number == "") {
                        // if number is empty, then this is the first digit
                        // set $startIndex to the index of the char before number
                        // or of the char itself if it is at index 0
                        $startIndex = ($j > 0) ? $j - 1 : $j;
                    }
                    // add digit to number
                    $number .= $line[$j];
                    // Set read digits to . s.t. they don't get counted more than once
                    $line[$j] = '.';

                } else if ($number !== "") { // else if the current char is not a digit
                    // then we have just read the number and we are at the symbol after it
                    // set $endIndex to the index of the char after number
                    // or of the char itself if it is at last postition in row
                    $endIndex = ($j < count($line) - 1) ? $j : $j - 1;

                    // loop over all chars adjacent to number
                    for ($index = $startIndex; $index <= $endIndex; $index++) {
                        // check row before number if number is not on the first row
                        $startRow = ($row > 0) ? $row - 1 : $row;
                        // check row after number if number is not on the last row
                        $endRow = ($row < count($input) - 1) ? $row + 1 : $row;

                        // loop over adjacent chars
                        for ($k = $startRow; $k <= $endRow; $k++) {

                            $char = trim(str_split($input[$k])[$index]);
                            if ($char !== "" && Challenge::isSymbol($char)) {
                                // once we see a symbol character, add number to result
                                $result += (int) $number;
                                $number = '';
                                break 2;
                            }
                        }
                    }
                    // also reset number if it is not counted
                    $number = '';
                }
            }
        }
        return $result;
    }

    function partTwo(array $input): int
    {
        $result = 0;

        for ($row = 0; $row < count($input); $row++) {
            $line = str_split($input[$row]);
            for ($charIndex = 0; $charIndex < count($line); $charIndex++) {
                if ($line[$charIndex] === "*") {
                    $gearIndex = $charIndex;
                    $input[$row][$gearIndex] = ".";

                    $startRow = ($row > 0) ? $row - 1 : $row;
                    $endRow = ($row < count($input) - 1) ? $row + 1 : $row;
                    $startIndex = ($gearIndex > 0) ? $gearIndex - 1 : $gearIndex;
                    $endIndex = ($gearIndex < count($line) - 1) ? $gearIndex + 1 : $gearIndex;

                    $firstNumber = "";
                    $secondNumber = "";

                    for ($i = $startRow; $i <= $endRow; $i++) {
                        for ($j = $startIndex; $j <= $endIndex; $j++) {
                            if (is_numeric($input[$i][$j])) {
                                if ($firstNumber == "") {
                                    list($firstNumber, $input[$i]) = Challenge::getGearNumber($input[$i], $j);
                                } else if ($secondNumber == "") {
                                    list($secondNumber, $input[$i]) = Challenge::getGearNumber($input[$i], $j);
                                    // echo "First number = " . $firstNumber . " secondNumber " . $secondNumber . PHP_EOL;
                                    $result += (int) $firstNumber * (int) $secondNumber;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    function main()
    {
        $input = file(__DIR__ . "/input.txt");
        // $input = file(__DIR__ . "/testInput.txt");

        // $result = Challenge::partOne($input);
        $result = Challenge::partTwo($input);


        echo ("Result: " . $result . "\n");
    }

}