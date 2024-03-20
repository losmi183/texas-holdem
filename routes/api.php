<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Set new table with cards and players
Route::get('/start-game', [GameController::class, 'gameStart']);

// Get table
Route::post('/get-all-tables', [GameController::class, 'getAllTables']);
Route::post('/get-table', [GameController::class, 'getTable']);
// Update table
Route::post('/update-table', [GameController::class, 'updateTable']);
// Delete table
Route::post('/delete-table', [GameController::class, 'deleteTable']);

