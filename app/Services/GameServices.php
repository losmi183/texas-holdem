<?php

namespace App\Services;

use App\Holdem\Deck;
use App\Holdem\Table;
use Illuminate\Support\Collection;
use App\Repositories\FirebaseRepository;

class GameServices {

    private DatabaseServices $databaseServices;
    private FirebaseRepository $firebaseRepository;

    public function __construct(DatabaseServices $databaseServices, FirebaseRepository $firebaseRepository) {
        $this->databaseServices = $databaseServices;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function gameInit(Collection $players, int $tableMaxSeats, int $buyIn, int $smallBlind, int $bigBlind)
    {   
        // Init empty table with players and deck
        $table = new Table($tableMaxSeats, $buyIn, $smallBlind, $bigBlind);

        $table->addPlayers($players);
        $table->deal();
        $table->evaluateHands();

        // Mariadb
        // $this->databaseServices->saveTableToDatabase($table);

        // Save to firebase
        $this->firebaseRepository->store($table);

        return $table;
    }
    public function getAllTables()
    {
        return $this->firebaseRepository->getAll();
    }

    public function getTable(array $params)
    {
        return $this->firebaseRepository->get($params['table_id']);
    }
    public function updateTable(array $params): bool
    {
        return $this->firebaseRepository->update($params['table_id']);
    }
    public function deleteTable(array $params): bool
    {
        return $this->firebaseRepository->delete($params['table_id']);
    }
}