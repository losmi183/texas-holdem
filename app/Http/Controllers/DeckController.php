<?php

namespace App\Http\Controllers;

use App\Holdem\Card;
use App\Holdem\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DeckController extends Controller
{
    public function startGame()
    {
        // $niz = [5,6,8,7,5,6];
        // $vremeTrajanja = 10;
        // Cache::put('milos', $niz, $vremeTrajanja);
        $res = Cache::get('milos');
        dd($res);
        // $deck = new Deck();
        // $deck->create();
        // dd($deck->get());
    }
}
