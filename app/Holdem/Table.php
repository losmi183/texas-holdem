<?php
namespace App\Holdem;

use Illuminate\Support\Collection;

class Table
{   
    private string $id;
    public int $tableMaxSeats;
    private Deck $deck;    
    public Collection $players;

    public function __construct(int $tableMaxSeats, ?Collection $players)
    {
        $this->id = rand(100,999).'-'. time();
        $this->tableMaxSeats = $tableMaxSeats;
        $this->deck = new Deck();
        $this->players = $players;
    }
}