<?php

namespace App\Holdem;

class Hand {
    public string $name;
    public int $handRank;
    public int $maxCardRank;

    public function __construct($name, $handRank, $maxCardRank) {
        $this->name = $name;
        $this->handRank = $handRank;
        $this->maxCardRank = $maxCardRank;
    }
}