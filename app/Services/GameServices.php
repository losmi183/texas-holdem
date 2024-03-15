<?php

namespace App\Services;

use App\Holdem\Deck;
use App\Holdem\Table;
use Illuminate\Support\Collection;

class GameServices {

    private DatabaseServices $databaseServices;

    public function __construct(DatabaseServices $databaseServices) {
        $this->databaseServices = $databaseServices;
    }

    public function gameInit(Collection $players, int $tableMaxSeats, int $buyIn, int $smallBlind, int $bigBlind): Table
    {   
        // Init empty table with players and deck
        $table = new Table($tableMaxSeats, $buyIn, $smallBlind, $bigBlind);

        $table->addPlayers($players);
        $table->deal();
        $table->evaluateHands();

        $this->databaseServices->saveTableToDatabase($table);

        return $table;    
    }

    public function getTable(array $params)
    {
        $table = $this->databaseServices->getTable($params['table_id']);
    }
}