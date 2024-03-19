<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;


class FirebaseController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function create()
    {
        dd($this->database);
    }
}
