<?php

namespace App\Repositories;

use App\Holdem\Table;
use Illuminate\Support\Facades\DB;

class GamesRepository
{
    public function store(Table $table): void
    {
        $cards = array_merge($table->flop, [$table->turn, $table->river]);
        DB::table('games')->insert([
            'table_id' => $table->id,
            'phase' => $table->phase,
            'pot' => 0,
            'flop' => json_encode($table->flop),
            'turn' => json_encode($table->turn),
            'river' => json_encode($table->river),
        ]);
    }


}