<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\FirebaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DeckController::class, 'create']);
Route::get('/session', function() {
    dd(session()->get('table'));
});
Route::get('/firebase', [FirebaseController::class, 'create']);


