<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GameServices;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use App\Services\DatabaseServices;
use App\Http\Requests\GetTableRequest;
use App\Http\Requests\DeleteTableRequest;
use App\Http\Requests\UpdateTableRequest;

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

        // session()->put('table', $table);
        // dd(session()->get('table'));

        return response()->json([
            'table_id' => $table->id
        ]);
    }

    public function getAllTables(GameServices $gameServices): JsonResponse
    {
        $result = $gameServices->getAllTables();
        return response()->json([
            'table_id' => $result
        ]);
    }

    public function getTable(GetTableRequest $request, GameServices $gameServices): JsonResponse
    {
        $params = $request->validated();
        $result = $gameServices->getTable($params);
        return response()->json([
            'table_id' => $result
        ]);
    }

    public function updateTable(UpdateTableRequest $request, GameServices $gameServices): JsonResponse
    {
        $params = $request->validated();
        if($gameServices->updateTable($params)) {
            return response()->json([
                'table_id' => 'Table update successfully'
            ]);
        } else {
            abort(400, 'Update not successfully');
        }
    }
    public function deleteTable(DeleteTableRequest $request, GameServices $gameServices): JsonResponse
    {
        $params = $request->validated();
        $result = $gameServices->deleteTable($params);
        if($gameServices->deleteTable($params)) {
            return response()->json([
                'table_id' => 'Table delete successfully'
            ]);
        } else {
            abort(400, 'Delete not successfully');
        }
    }
}
