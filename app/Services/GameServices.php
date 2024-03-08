<?php

namespace App\Services;

use App\Holdem\Deck;
use App\Holdem\Table;
use Illuminate\Support\Collection;

class GameServices {

    public function gameStart(Collection $players,  int $tableMaxSeats): void
    {   
        $table = new Table($tableMaxSeats, $players);

        dd($table);
    }

}