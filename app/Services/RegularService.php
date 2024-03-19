<?php 

namespace App\Services;

class RegularService
{
    public int $id;

    public function __construct()
    {
        $this->id = rand(1,1000);
    }
}