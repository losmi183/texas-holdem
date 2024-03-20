<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;


class FirebaseController extends Controller
{    
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function create()
    {
        $data = [
            'name' => 'glogovac',
            'age' => 40,
            'phones' => [
                'samsung' => 123456789,
                'apple' => 987654321
            ],
        ];
        $key = rand(0,999).'_'.time();

        $postRef = $this->database->getReference('table')->getChild($key)->set($data);        
    }
}
