<?php

namespace App\Services;

use App\Holdem\Deck;
use App\Holdem\Table;
use Illuminate\Support\Collection;

class GameServices {

    public function gameInit(Collection $players, int $tableMaxSeats): void
    {   
        // Init empty table with players and deck
        $table = new Table($tableMaxSeats);

        $table->addPlayers($players);
        $table->deal();
        $table->evaluateHands();

        // $table = $table->deal();
        session()->put('table', $table);
    
        // // Dohvati objekt iz sesije
        dd(session()->get('table'));
    
    }
}