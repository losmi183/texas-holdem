<?php

namespace App\Services;

use App\Holdem\Card;

class HandGenerator
{
    // public static function generateFlushRoyal(?Card $cards = null): array
    public static function generateStraightFlush(array $cards = null): array
    {
        // Generate cards if not 
        if($cards === null) {
            $cards = [];
            $numOfCards = 6;
            for ($i = 0; $i < $numOfCards; $i++) {
                $cards[] = new Card(2, 2, 2, '♥');
            }
        }
        foreach($cards as $key=>$card) {
            if($key>=6) {
                $card->suit_id = 2;
                $card->suit = '♥';
                $card->rank = 2 + $key +2;
                $card->symbol = 2 + $key+2;
                continue;
            }
            $card->rank = 2 + $key;
            $card->symbol = 2 + $key;
            $card->suit_id = 1;
            $card->suit = '♠';
        }
        return $cards;
    }
}