<?php

Challenge::main();

class Challenge
{
    static $part;
    public static function processLine(string $line)
    {
        echo ($line);
    }

    public static function getPairs(array $galaxies) : array {
        $pairs = [];
        for ($i = 0; $i < count($galaxies); $i++) {
            for ($j = $i + 1; $j < count($galaxies); $j++) {
                $pairs[] = [$galaxies[$i], $galaxies[$j]];
            }
        }
        return $pairs;
    }

    public static function computeDistances(array $pairs, array $input) : int {
        $result = 0;
        for ($pair = 0; $pair < count($pairs); $pair++) {
            if ($pairs[$pair][0][0] > $pairs[$pair][1][0]) {
                $largerX = $pairs[$pair][0][0];
                $smallerX = $pairs[$pair][1][0];
            } else {
                $largerX = $pairs[$pair][1][0];
                $smallerX = $pairs[$pair][0][0];
            }
            
            if ($pairs[$pair][0][1] > $pairs[$pair][1][1]) {
                $largerY = $pairs[$pair][0][1];
                $smallerY = $pairs[$pair][1][1];
            } else {
                $largerY = $pairs[$pair][1][1];
                $smallerY = $pairs[$pair][0][1];
            }
            
            for ($i = $smallerX + 1; $i <= $largerX; $i++) {
                $result += $input[$i][$smallerY][1];
            }
            for ($j = $smallerY + 1; $j <= $largerY; $j++ ) {
                $result += $input[$smallerX][$j][1];
            }
        }
        return $result;

    }

    public static function emptySpace ($row) : bool {
        foreach ($row as $value) {
            if ($value[0] == '#') {
                return false;
            }
        }
        return true;
    }

    public static function expandAndTranspose(array $universe) : array 
    {
        // $expanded = [];
        global $part;

        if ($part == 1) {
            $distance = 1;
        } else {
            $distance = 1000000;
        }

        for ($i = 0; $i < count($universe); $i++) {
            if (Challenge::emptySpace($universe[$i])) {
                for ($j = 0; $j < count($universe[$i]); $j++) {
                    $universe[$i][$j][1] *= $distance;
                }
            }
        }

        return array_map(null, ...$universe);
    }

    static function main()
    {
        $input = array_map(fn (string $line) => str_split(trim($line)), file(__DIR__ . "/testInput.txt"));
        $input = array_map(fn (string $line) => str_split(trim($line)), file(__DIR__ . "/input.txt"));
        global $part;
        $part = 2;
        for ($i = 0; $i < count($input); $i++) {
            for ($j = 0; $j < count($input[$i]); $j++) {
                $input[$i][$j] = [$input[$i][$j], 1];
            }
        }
        $result = 0;
        $output = "";

        $temp = Challenge::expandAndTranspose($input);
        $input = Challenge::expandAndTranspose($temp);

        for ($i = 0; $i < count($input); $i++) {
            for ($j = 0; $j < count($input[$i]); $j++) {
                $output .= "[" . $input[$i][$j][0] . ", " . $input[$i][$j][1] . "]"; // . " ";
            }

            $output .= PHP_EOL;
        }

        $galaxies = [];

        for ($i = 0; $i < count($input); $i++) {
            if (!Challenge::emptySpace($input[$i])) {
                for ($j = 0; $j < count($input[$i]); $j++) {
                    if ($input[$i][$j][0] == '#') {
                        $galaxies[] = [$i, $j];
                    }
                }
            }
        }
        
        $pairs = Challenge::getPairs($galaxies);
        $result = Challenge::computeDistances($pairs, $input);

        file_put_contents(__DIR__ . "/output.txt", $output);

        echo ("Result: " . $result . "\n");
    }

}