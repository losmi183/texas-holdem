<?php

namespace App\Repositories;

use App\Holdem\Table;
use Illuminate\Support\Facades\Log;
use App\Interfaces\DatabaseInterface;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Database\Reference;

class FirebaseRepository implements DatabaseInterface
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function get(string $key)
    {
        try {
            $table = $this->database->getReference('table')->getChild($key)->getValue();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500, 'Firebase error');
        }
        return $table;
    }

    public function store(Table $table): Reference
    {
        $key = $table->id;
        try {
            $postRef = $this->database->getReference('table')->getChild($key)->set($table);        
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500, 'Firebase error');
        }
        return $postRef;
    }
}