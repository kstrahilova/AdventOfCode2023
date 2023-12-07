<?php

Challenge::main();

class Challenge
{
    static function copyArray(array $original): array
    {
        $copy = [];
        foreach ($original as $value) {
            $copy[] = $value;
        }
        return $copy;
    }

    static function getTextualRepresentationOfType(int $type): string
    {
        switch ($type) {
            case 1:
                return "High card";
            case 2:
                return "One pair";
            case 3:
                return "Two pair";
            case 4:
                return "Three of a kind";
            case 5:
                return "Full house";
            case 6:
                return "Four of a kind";
            case 7:
                return "Five of a kind";
            default:
                return "ERROR";
        }
    }

    /**
     * @input $sorted
     * @output 
     *      switch($type):
     *          case "Five of a kind": 7
     *          case "Four of a kind": 6
     *          case "Full house (one triple and one pair)": 5
     *          case "Three of a kind": 4
     *          case "Two pair": 3
     *          case "One pair": 2
     *          case "High card": 1
     */
    static function getType(array $sorted): int
    {
        $frequencies = array_count_values($sorted);
        $rank = 0;
        switch (count($frequencies)) {
            case 1:
                $rank = 7;
                break;
            case 2:
                $rank = max($frequencies) + 2;
                break;
            case 3:
                $rank = max($frequencies) + 1;
                break;
            case 4:
                $rank = 2;
                break;
            default:
                $rank = 1;
                break;
        }

        if ($rank < 7 && isset($frequencies[1])) {
            // 1xxxx -> xxxxx || 1111x -> xxxxx || 11xxx -> xxxxx || 111xx -> xxxxx
            if ($rank == 6 || $rank == 5)
                return 7;
            // 1xyyy -> xyyyy
            // 111xy -> xxxxy
            if ($rank == 4)
                return 6;
            // 11xyy -> xyyyy, so 3 -> 6 = 3 + 1 + 2
            // 1xxyy -> xxxyy, so 3 -> 5 = 3 + 1 + 1
            if ($rank == 3)
                return $rank + 1 + $frequencies[1];
            // 11xyz -> xxxyz
            // 1xyzz -> xyzzz
            if ($rank == 2)
                return 4;
            // 1abcd => aabcd
            if ($rank == 1)
                return 2;
        }

        return $rank;
    }

    static function printHands(array $cards): string
    {
        $result = "";
        foreach ($cards as $card) {
            $result .= "Original hand: ";
            foreach ($card["original"] as $i) {
                $result .= $i . " ";
            }
            $result .= "\nMapped hand: ";
            foreach ($card["hand"] as $i) {
                $result .= $i . " ";
            }
            $result .= "\nType: " . $card["type"] . " => " . Challenge::getTextualRepresentationOfType($card["type"]) . "\nBet = " . $card["bet"] . "\n\n";
        }

        return $result;
    }

    static function compare(array $a, array $b): int
    {
        if ($a["type"] == $b["type"]) {
            for ($i = 0; $i < count($a["hand"]); $i++) {
                $first = $a["hand"][$i];
                $second = $b["hand"][$i];
                if ($first < $second) {
                    return -1;
                } else if ($first > $second) {
                    return 1;
                }
            }
            return 0;

        } else {
            $first = $a["type"];
            $second = $b["type"];
            if ($first < $second) {
                return -1;
            } else if ($first > $second) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    static function processLine(string $line, int $part): array
    {
        $line = explode(" ", trim($line));
        $original = str_split($line[0]);
        $hand = str_split($line[0]);
        if ($part != 1) {
            $hand = array_map(fn($card) => ($card == "J") ? 1 : $card, $hand);
        }

        $hand = array_map(function ($card) {
            $T = 10;
            switch ($card) {
                case "T":
                    return $T;
                case "J":
                    return $T + 1;
                case "Q":
                    return $T + 2;
                case "K":
                    return $T + 3;
                case "A":
                    return $T + 4;
                default:
                    return $card;
            }
        }, $hand);

        $sorted = Challenge::copyArray($hand);
        sort($sorted);

        $type = Challenge::getType($sorted);

        return [
            "original" => $original,
            "hand" => $hand,
            "type" => $type,
            "bet" => (int) $line[1],
        ];
    }

    static function main()
    {
        // $input = file(__DIR__ . "/testInput.txt");
        $input = file(__DIR__ . "/input.txt");
        // $part = 1;
        $part = 2;
        $result = 0;
        $cards = [];

        foreach ($input as $line) {
            $cards[] = Challenge::processLine($line, $part);
        }

        usort($cards, "Challenge::compare");

        // $output = Challenge::printHands($cards);
        // file_put_contents(__DIR__ . "/output.txt", $output);

        for ($i = 0; $i < count($cards); $i++) {
            $winnings = $cards[$i]["bet"] * ($i + 1);
            $result += $winnings;
        }

        echo ("Result: " . $result . "\n");
    }

}