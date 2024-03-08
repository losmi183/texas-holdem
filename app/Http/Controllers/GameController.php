<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GameServices;

class GameController extends Controller
{
    

    public function gameStart(GameServices $gameServices)
    {
        // 4 random players on 6 seats table
        $gameServices->gameStart(User::take(4)->get(), 6);
    }
}
