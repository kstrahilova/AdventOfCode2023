<?php

Challenge::main();

class Challenge
{
    static $output = "";
    static function processDifferences(array $differences): array
    {
        global $output;
        for ($i = count($differences) - 2; $i >= 0; $i--) {
            $diffEnd = $differences[$i + 1][count($differences[$i + 1]) - 1] + $differences[$i][count($differences[$i]) - 1];
            $differences[$i][] = $diffEnd;
            $diffStart = $differences[$i][1] - $differences[$i + 1][0];
            $differences[$i][0] = $diffStart;
            $output .= "First " . $diffStart . " Last " . $diffEnd . " ";
        }
        $output .= PHP_EOL;

        return [
            1 => $differences[0][count($differences[0]) - 1],
            2 => $differences[0][0]
        ];
    }

    static function processLine(string $line): array
    {
        $done = false;
        $differences[0] = (explode(" ", trim($line)));
        $differences[0] = array_map(function ($value) {
            if (is_numeric($value)) {
                return $value;
            }
        }, $differences[0]);

        $differences[0] = array_merge([0], $differences[0]);
        $index = 0;

        while (!$done) {
            $differences[$index + 1][] = 0;

            for ($i = 1; $i < count($differences[$index]) - 1; $i++) {
                $differences[$index + 1][] = $differences[$index][$i + 1] - $differences[$index][$i];
            }

            if (count(array_count_values($differences[$index + 1])) == 1 && $differences[$index + 1][0] == 0) {
                $done = true;
                // Add new zero
                $differences[$index + 1][] = 0;
            }
            global $output;

            for ($i = 0; $i < count($differences[$index]); $i++) {
                $output .= $differences[$index][$i] . " ";
            }
            $output .= "\n";
            $index += 1;
        }

        return Challenge::processDifferences($differences);
    }

    static function main()
    {
        $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        $resultPt1 = 0;
        $resultPt2 = 0;
        global $output;

        for ($i = 0; $i < count($input); $i++) {
            $line = trim($input[$i]);
            if ($line !== "") {
                $newValue = Challenge::processLine($line);
                $output .= "New values = " . $newValue[1] . " " . $newValue[2] ."\n";
                $resultPt1 += $newValue[1];
                $resultPt2 += $newValue[2];
            }
        }

        file_put_contents(__DIR__ . "/output.txt", $output);

        echo ("Result Part One: " . $resultPt1 . "\nResul Part Two: " . $resultPt2 . "\n");
    }

}