<?php

namespace App\Repositories;

use App\Holdem\Table;
use Illuminate\Support\Facades\DB;

class TableRepository
{
    public function store(Table $table): void
    {
        // DB::table('tables')->insert([
        //     'id' => $table->id,
        //     'phase' => $table->phase,
        //     'pot' => $table->pot,
        //     'table_cards' => json_encode($table->tableCards),
        //     'big_blind' => $table->bigBlind,
        // ]);
    }


}