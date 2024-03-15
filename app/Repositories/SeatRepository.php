<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class SeatRepository
{
    public function store(array $seats, int $tableId)
    {
        foreach ($seats as $slot => $seat) {
            if($seat) {
                DB::table('seats')->insert([
                    'table_id' => $tableId,
                    'slot' => $slot, // index in array
                    'user_id' => $seat->id,
                    'player_name' => $seat->name,
                    'chips' => 1000,
                    'hand' => json_encode($seat->hand),
                    'final_cards' => json_encode($seat->finalCards),
                    'active' => true
                ]);
            }
        }
    }
}