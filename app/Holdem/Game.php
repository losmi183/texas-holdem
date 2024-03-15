<?php
namespace App\Holdem;

use App\Holdem\Player;
use App\Services\HandEvaluatorService;
use Illuminate\Support\Collection;

class Game
{   
    // Table fields
    public array $config;
    public string $id;
    public int $tableMaxSeats;
    public int $buyIn = 20;
    public int $smallBlind = 5;
    public int $bigBlind = 10;

    // Game fields
    public int $phase = 0;
    public int $pot = 0;
    public array $seats;
    private Deck $deck;    
    public Collection $players;
    public ?array $flop = null;
    public ?Card $turn = null;
    public ?Card $river = null;

    public function __construct(int $tableMaxSeats, int $buyIn, int $smallBlind, int $bigBlind)
    {
        $this->config = config('holdem');
        $this->id = rand(100,999) . time(); // random id for table generate from 100-999 and timestamp
        $this->tableMaxSeats = $tableMaxSeats;
        $this->buyIn = $buyIn;
        $this->smallBlind = $smallBlind;
        $this->bigBlind = $bigBlind;
        
        $this->deck = new Deck($this->config['card'], $this->config['suit'] );
        
        // Generate empty seats array
        for ($i = 0; $i < $this->tableMaxSeats; $i++) {
            $this->seats[$i] = null;            
        }   
    }

    public function addPlayers(?Collection $players): void
    {
        $this->players = $players;
        // Adding players to seats
        foreach ($this->players as $key => $player) {
            $this->seats[$key] = new Player($player);
        }
    }

    public function deal(): void
    {
        // Deal first cards to players
        foreach ($this->seats as $key => $seat) {
            if ($seat) {
                $seat->hand[] = $this->deck->dealCard();
            }
        }
        // Deal second cards to players
        foreach ($this->seats as $key => $seat) {
            if ($seat) {
                $seat->hand[] = $this->deck->dealCard();
            }
        }
        // Deal $flop
        for($i=1; $i<=3; $i++) {
            $this->flop[] = $this->deck->dealCard();
        }
        // Deal turn 
        $this->turn = $this->deck->dealCard();
        // Deal river 
        $this->river = $this->deck->dealCard();
    }

    public function evaluateHands(): void
    {
        /**
         * Evaluate every player hand
         */
        $handEvaluatorService = new HandEvaluatorService;
        $tableCards = array_merge($this->flop, [$this->turn], [$this->river]);
        foreach ($this->seats as $key => $seat) {
            if ($seat) {
                $playerAndTableCards = array_merge($tableCards, $seat->hand);
                $seat->finalCards = $handEvaluatorService->evaluateHand($playerAndTableCards, $this->config['card'], $this->config['suit']);     
            }
        }
    }
}