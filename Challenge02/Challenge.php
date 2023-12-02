<?php

Challenge::main();

class Challenge
{
    function processLinePt1(string $line): int
    {
        $red = "red";
        $green = "green";
        $blue = "blue";

        $nRed = 12;
        $nGreen = 13;
        $nBlue = 14;
        list($game, $subsets) = explode(": ", $line);
        $game = explode(" ", $game)[1];
        $subsets = explode("; ", $subsets);

        foreach ($subsets as $subset) {
            $cubes = explode(", ", $subset);
            foreach ($cubes as $cube) {
                $cube = explode(" ", $cube);
                $number = $cube[0];
                $color = trim($cube[1]);

                if (($number > $nRed && $color == $red) || ($number > $nGreen && $color == $green) || ($number > $nBlue && $color == $blue)) {
                    return 0;
                }
            }
        }

        return (int) $game;

    }

    function processLine(string $line, bool $partOne): int
    {
        $red = "red";
        $green = "green";
        $blue = "blue";

        if ($partOne) {
            $nRed = 12;
            $nGreen = 13;
            $nBlue = 14;
        } else {
            $nRed = 0;
            $nGreen = 0;
            $nBlue = 0;
        }

        list($game, $subsets) = explode(": ", $line);
        $game = explode(" ", $game)[1];
        $subsets = explode("; ", $subsets);

        foreach ($subsets as $subset) {
            $cubes = explode(", ", $subset);
            foreach ($cubes as $cube) {
                $cube = explode(" ", $cube);
                $number = $cube[0];
                $color = trim($cube[1]);

                if ($partOne) {
                    if (($number > $nRed && $color == $red) || ($number > $nGreen && $color == $green) || ($number > $nBlue && $color == $blue)) {
                        return 0;
                    }
                } else {
                    if ($color == $red && $number > $nRed) {
                        $nRed = $number;
                    } else if ($color == $green && $number > $nGreen) {
                        $nGreen = $number;
                    } else if ($color == $blue && $number > $nBlue) {
                        $nBlue = $number;
                    }
                }

            }
        }

        if ($partOne) {
            return (int) $game;
        } else {
            return $nRed * $nGreen * $nBlue;
        }
    }

    function main()
    {
        // $partOne = true;
        $partOne = false;
        $input = file(__DIR__ . "/input.txt");
        // $input = file(__DIR__ . "/testInput.txt");
        $result = 0;

        foreach ($input as $line) {
            if (trim($line) !== "") {
                $result += Challenge::processLine($line, $partOne);
            }
        }

        echo ("Result: " . $result . "\n");
    }

}