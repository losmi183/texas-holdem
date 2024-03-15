<?php

namespace App\Services;
use App\Holdem\Table;
use App\Repositories\TableRepository;

class DatabaseServices
{
    private TableRepository $tableRepository;

    public function __construct() {
        $this->tableRepository = new TableRepository();
    }

    public function saveTableToDatabase(Table $table): bool
    {
        $this->tableRepository->store($table);

        return true;
    }
}