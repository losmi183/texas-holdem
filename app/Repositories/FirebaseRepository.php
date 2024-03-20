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

    public function getAll(): array
    {
        try {
            $reference = $this->database->getReference('table');
            $snapshot = $reference->getSnapshot();
            $tables = [];
    
            foreach ($snapshot->getValue() as $key => $value) {
                if(isset($value['id'])) {
                    $tables[$key]['table_id'] = $value['id'];
                    $tables[$key]['players'] = count($value['players']);
                }
            }
    
            return $tables;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500, 'Firebase error');
        }
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

    public function update(string $key): bool
    {
        try {
            $reference = $this->database->getReference('table')->getChild($key);
            $reference->update([
                'pot' => 654 // Ovdje možete postaviti bilo koju novu vrijednost za 'pot'
            ]);
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500, 'Firebase error');
        }
    }
    public function delete(string $key): bool
    {
        try {
            $reference = $this->database->getReference('table')->getChild($key);
            $reference->remove();
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(500, 'Firebase error');
        }
    }
}