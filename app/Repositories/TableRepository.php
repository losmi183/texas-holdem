<?php

namespace App\Repositories;

use App\Holdem\Table;
use Illuminate\Support\Facades\DB;

class TableRepository
{
    public function store(Table $table): void
    {
        DB::table('tables')->insert([
            'id' => $table->id,
            'table_max_seats' => $table->tableMaxSeats,
            'buy_in' => $table->buyIn,
            'small_blind' => $table->smallBlind,
            'big_blind' => $table->bigBlind,
        ]);
    }


}