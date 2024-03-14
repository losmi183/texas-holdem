<?php

namespace App\Services;

use App\Holdem\Hand;

class HandEvaluatorService
{
    private array $handRanks;

    public function __construct(Type $var = null) {
        $this->handRanks = config('holdem.handRanks');
    }

    public function evaluateHand(array $cards, array $rank, array $suit)
    {   
        // $cards = HandGenerator::generateStraightFlush($cards);
        $cards = HandGenerator::generateFourOfAKind($cards);
        $hand = new \stdClass;

        $ranks = $this->rankCounts($cards, $rank, $suit);
        $suits = $this->suitCounts($cards, $rank, $suit);     

        $this->isFlushStraight($cards, $ranks, $suits);
        
        // Card ranks 9 and 8 - Flush Royal and Strait Flush  
        if ($hand = $this->isFlushStraight($cards, $ranks, $suits)) {
            return $hand;  
        }
        // Card rank 7 -Four Of A Kind
        if ($hand = $this->isFourOfAKind($cards, $ranks, $suits)) {
            return $hand;  
        }
    }


    private function isFlushStraight(array $cards, array $ranks, array $suits): Hand|bool
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
            if($maxRank == 14) {
                return new Hand($this->handRanks[9], 9, $maxRank); // Flush Royal (9)
            }
            return new Hand($this->handRanks[8], 8, $maxRank); // Strait flush (8)
        } else {
            return false;
        }
    }

    private function isFourOfAKind(array $cards, array $ranks, array $suits): Hand|bool
    {
        $fourOfAKind = false;
        $maxCardRank = false;
        $secondMaxCardRank = 0;
        foreach ($ranks as $rank_id => $number) {
            if($number == 4) {
                $fourOfAKind = true;
                $maxCardRank = $rank_id;
            } else {
                if($rank_id > $secondMaxCardRank) {
                    $secondMaxCardRank = $rank_id;
                }
            }
        }
        if($fourOfAKind) {
            return new Hand($this->handRanks[7], 7, $maxCardRank, $secondMaxCardRank); // Strait flush (8)
        }
        return false;
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