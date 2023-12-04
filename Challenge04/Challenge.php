<?php

Challenge::main();

class Challenge
{
    static function processLine(string $line) : array // int
    {
        $line = explode(': ', trim($line));
        $card = explode(' ', $line[0])[1];
        list($winning, $actual) = explode(' | ', $line[1]);
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

        // $result = ($matches > 0) ? 2 ** ($matches - 1) : 0;
        // return $result;
        echo "Card " . $card . " matches " . $matches . PHP_EOL;
        return [$card, $matches];
    }

    static function processCard(array $cards, int $current) : int {
        $matches = $cards[$current];
        $result = 1;

        for ($i = $current + 1; $i <= $current + $matches; $i++) {
            $result += 1 + Challenge::processCard($cards, $i);
        }

        return $result;
    }

    static function main()
    {
        // $input = file(__DIR__ . "/input.txt");
        $input = file(__DIR__ . "/testInput.txt");
        $result = 0;
        $cards = [];

        foreach ($input as $line) {
            // $result += Challenge::processLine($line);
            $card = Challenge::processLine($line);
            $cards[$card[0]] = $card[1];
        }

        for ($i = 1; $i <= count($cards); $i++) {
            $result += Challenge::processCard($cards, $i);
        }

        echo ("Result: " . $result . "\n");
    }

}