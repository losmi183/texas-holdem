<?php

namespace App\Services;
use App\Holdem\Table;
use App\Repositories\SeatRepository;
use App\Repositories\GamesRepository;
use App\Repositories\TableRepository;

class DatabaseServices
{
    private TableRepository $tableRepository;
    private GamesRepository $gameRepository;
    private SeatRepository $seatRepository;

    public function __construct() {
        $this->tableRepository = new TableRepository();
        $this->gameRepository = new GamesRepository();
        $this->seatRepository = new SeatRepository();
    }

    public function saveTableToDatabase(Table $table): bool
    {
        $this->tableRepository->store($table);
        $this->gameRepository->store($table);
        $this->seatRepository->store($table->seats, $table->id);

        return true;
    }
}