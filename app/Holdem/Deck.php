<?php

namespace App\Holdem;

class Deck {
    private $cards = [];
    private $config = [];

    public function __construct() 
    {        
        $this->config = config('holdem');
        $this->create();
        shuffle($this->cards);
    }

    public function create(): void
    {
        foreach ($this->config['card'] as $rank => $symbol) {
            foreach ($this->config['suit'] as $suit_id => $suit) {
                $this->cards[] = new Card($rank, $symbol, $suit_id, $suit);
            }
        }
    }

    public function get(): array
    {
        return $this->cards;
    }

}