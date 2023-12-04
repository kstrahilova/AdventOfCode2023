<?php

Challenge::main();

class Challenge
{
    static function processLine(string $line): array // int
    {
        $line = preg_replace('/([\s.\',-])\1+/', '$1', $line);
        $line = explode(': ', trim($line));
        $card = explode(' ', $line[0])[1];
        list($winning, $actual) = explode(' | ', $line[1]);
        $winning = explode(' ', $winning);
        array_walk($winning, fn(string $string) => trim($string));
        $actual = explode(' ', $actual);
        array_walk($actual, fn(string $string) => trim($string));
        $matches = 0;
        foreach ($winning as $winningNumber) {
            if (in_array($winningNumber, $actual) && $winningNumber !== "") {
                $matches += 1;
            }
        }

        // $result = ($matches > 0) ? 2 ** ($matches - 1) : 0;
        // return $result;
        return [$card, $matches];
    }

    static function processCard(array $cards, int $current, array $nCopies): array
    {
        $matches = $cards[$current];

        return $nCopies;
    }

    static function main()
    {
        $input = file(__DIR__ . "/input.txt");
        // $input = file(__DIR__ . "/testInput.txt");
        $result = 0;
        $cards = [];
        $nCopies = [];

        foreach ($input as $line) {
            // $result += Challenge::processLine($line);
            $card = Challenge::processLine($line);
            $cards[$card[0]] = $card[1];
            $nCopies[$card[0]] = 1;
        }

        for ($i = 1; $i <= count($cards); $i++) {
            for ($j = $i + 1; $j <= $i + $cards[$i]; $j++) {
                $nCopies[$j] += $nCopies[$i];
            }
        }
        $result = array_sum($nCopies);

        echo ("Result: " . $result . "\n");
    }

}