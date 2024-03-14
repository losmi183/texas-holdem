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
            $card->rank = 8 + $key;
            $card->symbol = 8 + $key;
            $card->suit_id = 1;
            $card->suit = '♠';
        }
        return $cards;
    }

    public static function generateFourOfAKind(array $cards = null): array
    {
        $config = config('holdem');
        $suitsArray = $config['suit'];
        // Generiši karte ako nisu date
        if ($cards === null) {
            $cards = [];
            $numOfCards = 7;
            for ($i = 0; $i < $numOfCards; $i++) {
                $cards[] = new Card(2, 2, 2, '♥');
            }
        }
        foreach ($cards as $key => $card) {
            if ($key < 4) {
                $card->suit_id = $key+1;
                $card->suit = $suitsArray[$key+1];
                $card->rank = 10;
                $card->symbol = 10;
                continue;
            } else{
                $card->suit_id = 1;
                $card->suit = '♠';
                $card->rank = 2 + $key;
                $card->symbol = 2 + $key;
            }
        }
        return $cards;
    }

    public static function fullHouse(array $cards = null): array
    {
        $config = config('holdem');
        $suitsArray = $config['suit'];
        // Generiši karte ako nisu date
        if ($cards === null) {
            $cards = [];
            $numOfCards = 7;
            for ($i = 0; $i < $numOfCards; $i++) {
                $cards[] = new Card(2, 2, 2, '♥');
            }
        }
        foreach ($cards as $key => $card) {
            if ($key < 3) {
                $card->suit_id = $key+1;
                $card->suit = $suitsArray[$key+1];
                $card->rank = 10;
                $card->symbol = 10;
                continue;
            } elseif ($key==3 || $key==4) {
                $card->suit_id = $key-1;
                $card->suit = $suitsArray[$key-1];
                $card->rank = 9;
                $card->symbol = 9;
                continue;
            } 
            else{
                $card->suit_id = 1;
                $card->suit = '♠';
                $card->rank = 2 + $key;
                $card->symbol = 2 + $key;
            }
        }
        return $cards;
    }


    public static function flush(array $cards = null): array
    {
        // Generate cards if not 
        $cards = [];
        $cards[] = new Card(2, 2, 2, '♥');
        $cards[] = new Card(3, 3, 2, '♥');
        $cards[] = new Card(4, 4, 2, '♥');
        $cards[] = new Card(6, 6, 2, '♥');
        $cards[] = new Card(7, 7, 2, '♥');
        $cards[] = new Card(9, 9, 1, '♠');
        $cards[] = new Card(10, 10, 1, '♠');
        return $cards;
    }
}