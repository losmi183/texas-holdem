<?php

namespace App\Services;

class HandEvaluatorService
{
    public function evaluateHand(array $cards, array $rank, array $suit)
    {   
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
        $hand = new \stdClass;

        $ranks = $this->rankCounts($cards, $rank, $suit);
        $suits = $this->suitCounts($cards, $rank, $suit);     

        $this->isFlushStraight($cards, $ranks, $suits);
        
        // if ($hand = $this->isFlushStraight($cards, $ranks, $suits)) {
        //     return $hand;
        // }
    }

    private function isFlushStraight(array $cards, array $ranks, array $suits) 
    {   
        // Finding flush - 5 of the same suit
        $flush = false;
        foreach ($suits as $suit_id => $number) {
            if($number >= 5) {
                $flush = array_filter($cards, function($card) use ($suit_id) {
                    return $card->suit_id == $suit_id;
                });
            }
        }
        dump($flush);
        if(!$flush) {
            return false;
        }

        // Check consecutive ranks
        $consecutiveCount = 1;
        $maxConsecutiveCount = 1;
        $maxRank = $cards[0]->rank;
        for ($i = 1; $i < count($cards); $i++) {
            if ($cards[$i]->rank == $cards[$i - 1]->rank + 1) {
                $consecutiveCount++;
                if ($consecutiveCount > $maxConsecutiveCount) {
                    $maxConsecutiveCount = $consecutiveCount;
                    $maxRank = $cards[$i]->rank;
                }
            } else {
                $consecutiveCount = 1;
            }
        }

        // Checking for at least 5 consecutive cards
        if ($maxConsecutiveCount >= 5) {
            return $maxRank; // Returns the highest rank card in strait
        } else {
            return false;
        }
        

    }
    
    

    private function rankCounts(array $cards, array $rank, array $suit): array
    {       
        $rankCounts = [];
        foreach ($cards as $card) {
            if (!isset($rankCounts[$card->rank])) {
                $rankCounts[$card->rank] = 0;
            }
            $rankCounts[$card->rank]++;
        }
        return $rankCounts;
    }
    private function suitCounts(array $cards, array $rank, array $suit): array
    {
        $suitCounts = [];
        foreach ($cards as $card) {
            if (!isset($suitCounts[$card->suit_id])) {
                $suitCounts[$card->suit_id] = 0;
            }
            $suitCounts[$card->suit_id]++;
        }
        return $suitCounts;
    }
}