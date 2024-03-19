<?php

namespace App\Http\Controllers;

use App\Holdem\Card;
use App\Holdem\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Test $test): void
    {
        dd($test);
    }
}
