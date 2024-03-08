<?php

namespace App\Holdem;

class Card {
    private string $rank;
    public static $card;
    private int $suit_id;
    private string $suit;
    private string $symbol;

    public function __construct(int $rank, string $symbol, int $suit_id, string $suit) {
        $this->rank = $rank;
        $this->suit_id = $suit_id;
        $this->suit = $suit;
        $this->symbol = $symbol;
    }

}