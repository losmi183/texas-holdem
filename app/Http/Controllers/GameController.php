<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GameServices;
use App\Services\UserServices;
use App\Services\DatabaseServices;

class GameController extends Controller
{
    

    public function gameStart(GameServices $gameServices, UserServices $userServices, DatabaseServices $databaseServices)
    {
        // 4 random players on 6 seats table
        $players = $userServices->getRandomUsers(4);
        $tableMaxSeats = 6;
        $buyIn = 1000;
        $smallBlind = 10;
        $bigBlind = 20;
        
        $table = $gameServices->gameInit($players, $tableMaxSeats, $buyIn, $smallBlind, $bigBlind);

        $result = $databaseServices->saveTableToDatabase($table);

        session()->put('table', $table);
        dd(session()->get('table'));
    }

    public function play()
    {
        dd(session()->get('table'));
    }
}
