<?php

namespace App\Holdem;

class Deck {
    private array $card;
    private array $suit;

    public $cards = [];
    public function __construct(array $card, array $suit) 
    {   
        $this->card = $card;
        $this->suit = $suit;
        $this->create();
        shuffle($this->cards);
    }

    public function create(): void
    {
        foreach ($this->card as $rank => $symbol) {
            foreach ($this->suit as $suit_id => $suit) {
                $this->cards[] = new Card($rank, $symbol, $suit_id, $suit);
            }
        }
    }

    public function dealCard(): Card
    {
        $card = $this->cards[0];
        unset($this->cards[0]);        
        $this->cards = array_values($this->cards);
        return $card;
    }
}