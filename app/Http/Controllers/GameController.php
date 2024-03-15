<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\GameServices;
use App\Services\UserServices;
use App\Services\DatabaseServices;
use App\Http\Requests\GetTableRequest;

class GameController extends Controller
{
    

    public function gameStart(GameServices $gameServices, UserServices $userServices): JsonResponse
    {
        // 4 random players on 6 seats table
        $players = $userServices->getRandomUsers(4);
        $tableMaxSeats = 6;
        $buyIn = 1000;
        $smallBlind = 10;
        $bigBlind = 20;
        
        $table = $gameServices->gameInit($players, $tableMaxSeats, $buyIn, $smallBlind, $bigBlind);

        session()->put('table', $table);
        dd(session()->get('table'));

        return response()->json($table);
    }

    public function getTable(GetTableRequest $request, GameServices $gameServices)
    {
        $params = $request->validated();

        $result = $gameServices->getTable($params);
    }
}
