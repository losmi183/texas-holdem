<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GameServices;
use App\Services\UserServices;

class GameController extends Controller
{
    

    public function gameStart(GameServices $gameServices, UserServices $userServices)
    {
        // 4 random players on 6 seats table
        $players = $userServices->getRandomUsers(4);
        
        $gameServices->gameInit($players, 6);
    }

    public function play()
    {
        dd(session()->get('table'));
    }
}
