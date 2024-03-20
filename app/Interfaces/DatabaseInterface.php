<?php

namespace App\Interfaces;

use App\Holdem\Table;

interface DatabaseInterface {

    // public function getAll();
    public function get(string $key);
    public function store(Table $table);
    public function update();
    public function delete();
}