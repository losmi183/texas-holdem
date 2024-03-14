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
        // $cards = HandGenerator::generateFourOfAKind($cards);
        // $cards = HandGenerator::fullHouse($cards);
        // $cards = HandGenerator::flush($cards);
        $cards = HandGenerator::straight($cards);
        $hand = new \stdClass;

        $ranks = $this->rankCounts($cards, $rank, $suit);
        $suits = $this->suitCounts($cards, $rank, $suit);     

        // Card ranks 9 and 8 - Flush Royal and Strait Flush  
        if ($hand = $this->isFlushStraight($cards, $ranks, $suits)) {
            return $hand;  
        }
        // Card rank 7 -Four Of A Kind
        if ($hand = $this->isFourOfAKind($cards, $ranks, $suits)) {
            return $hand;  
        }
        // Card rank 6 -Full House
        if ($hand = $this->isFullHouse($cards, $ranks, $suits)) {
            return $hand;  
        }
        // Card rank 5 -Flush
        if ($hand = $this->isFlush($cards, $ranks, $suits)) {
            return $hand;  
        }
        // Card rank 4 - Straight
        if ($hand = $this->isStraight($cards, $ranks, $suits)) {
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
    
    private function isFullHouse(array $cards, array $ranks, array $suits): Hand|bool
    {
        $treeOfAKind = false;
        $twoOfAKind = false;
        $maxCardRank = false;
        $secondMaxCardRank = false;
        foreach ($ranks as $rank_id => $number) {
            if($number == 3) {
                $treeOfAKind = true;
                $maxCardRank = $rank_id;
            } elseif($number == 2) {
                $twoOfAKind = true;
                $secondMaxCardRank = $rank_id;
            }         
        }
        if($treeOfAKind && $twoOfAKind) {
            return new Hand($this->handRanks[6], 6, $maxCardRank, $secondMaxCardRank); // Strait flush (8)
        }
        return false;
    }
    private function isFlush(array $cards, array $ranks, array $suits): Hand|bool
    {
        $flush = false;
        $suit_id = null;
        $maxCardRank = 0;
        foreach ($suits as $suit => $number) {
            if($number == 5) {
                $flush = true;
                $suit_id = $suit;
            }  
        }
        if($flush) {            
            foreach ($cards as $card) {
                if ($card->suit_id === $suit_id && $card->rank > $maxCardRank) {
                    $maxCardRank = $card->rank;
                }
            }            
            
            return new Hand($this->handRanks[5], 5, $maxCardRank); // Strait flush (8)
        }
        return false;
    }
    
    private function isStraight(array $cards): Hand|bool
    {
        // sort by rank
        usort($cards, function($a, $b) {
            return $a->rank - $b->rank;
        });

        // check sequence of 5
        $consecutiveCount = 1;
        $maxConsecutiveCount = 1;
        $maxRank = $cards[0]->rank;
        $startIndex = 0;
        for ($i = 1; $i < count($cards); $i++) {
            if ($cards[$i]->rank == $cards[$i - 1]->rank + 1) {
                $consecutiveCount++;
                if ($consecutiveCount > $maxConsecutiveCount) {
                    $maxConsecutiveCount = $consecutiveCount;
                    $maxRank = $cards[$i]->rank;
                    $startIndex = $i - $maxConsecutiveCount + 1;
                }
            } elseif ($cards[$i]->rank != $cards[$i - 1]->rank) {
                $consecutiveCount = 1;
            }
        }

        // Checking for at least 5 consecutive cards
        if ($maxConsecutiveCount >= 5) {
            // $straightCards = array_slice($cards, $startIndex, $maxConsecutiveCount);
            return new Hand($this->handRanks[4], 4, $maxRank); // Straight (4)
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