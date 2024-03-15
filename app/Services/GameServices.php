<?php

namespace App\Services;

use App\Holdem\Deck;
use App\Holdem\Table;
use Illuminate\Support\Collection;

class GameServices {

    public function gameInit(Collection $players, int $tableMaxSeats, int $buyIn, int $smallBlind, int $bigBlind): Table
    {   
        // Init empty table with players and deck
        $table = new Table($tableMaxSeats, $buyIn, $smallBlind, $bigBlind);

        $table->addPlayers($players);
        $table->deal();
        $table->evaluateHands();

        return $table;    
    }
}