<?php

namespace App\Holdem;

class Hand {
    public string $name;
    public int $handRank;
    public ?int $maxCardRank;
    public ?int $secondMaxCardRank;

    public function __construct($name, $handRank, $maxCardRank, $secondMaxCardRank = null) {
        $this->name = $name;
        $this->handRank = $handRank;
        $this->maxCardRank = $maxCardRank;
        $this->secondMaxCardRank = $secondMaxCardRank;
    }
}