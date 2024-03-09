<?php

namespace App\Services;

use App\Holdem\Deck;
use App\Holdem\Table;
use Illuminate\Support\Collection;

class GameServices {

    public function gameInit(Collection $players,  int $tableMaxSeats): void
    {   
        $table = new Table($tableMaxSeats, $players);
        session()->put('table', $table);
    
        // // Dohvati objekt iz sesije
        dd(session()->get('table'));
    
    }
}