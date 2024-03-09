<?php 

namespace App\Holdem;

use App\Models\User;

class Player {

    public int $id;
    public string $name;
    public int $chips;
    public array $hand;

    public function __construct(User $user) {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->chips = 1000;
        $this->hand = [];
    }
}