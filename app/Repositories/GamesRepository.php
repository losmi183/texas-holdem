<?php

namespace App\Repositories;

use App\Holdem\Table;
use Illuminate\Support\Facades\DB;

class GamesRepository
{
    public function store(Table $table): void
    {
        DB::table('games')->insert([
            'table_max_seats' => $table->id,
            'buy_in' => $table->buyIn,
            'small_blind' => $table->smallBlind,
            'big_blind' => $table->bigBlind,
        ]);
    }


}