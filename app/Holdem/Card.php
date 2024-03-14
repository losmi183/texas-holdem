<?php

namespace App\Holdem;

class Card {
    public string $rank;
    public int $suit_id;
    public string $suit;
    public string $symbol;

    public function __construct(int $rank, string $symbol, int $suit_id, string $suit) {
        $this->rank = $rank;
        $this->suit_id = $suit_id;
        $this->suit = $suit;
        $this->symbol = $symbol;
    }

}