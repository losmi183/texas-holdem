<?php
namespace App\Holdem;

use App\Holdem\Player;
use App\Services\HandEvaluatorService;
use Illuminate\Support\Collection;

class Table
{   
    public array $config;
    private string $id;
    public int $phase = 0;
    public int $pot = 0;
    public int $buyInn = 20;
    public int $tableMaxSeats;
    public array $seats;
    private Deck $deck;    
    public Collection $players;
    // dealed cards
    private ?array $flop = null;
    private ?Card $turn = null;
    private ?Card $river = null;

    public function __construct(int $tableMaxSeats, ?Collection $players)
    {
        $this->config = config('holdem');
        $this->id = rand(100,999).'-'. time();
        $this->tableMaxSeats = $tableMaxSeats;
        $this->deck = new Deck($this->config['card'], $this->config['suit'] );
        $this->players = $players;

        // Generate empty seats array
        for ($i = 0; $i < $this->tableMaxSeats; $i++) {
            $this->seats[$i] = null;            
        }
        // Adding players to seats
        foreach ($this->players as $key => $player) {
            $this->seats[$key] = new Player($player);
        }

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

        $cards = array_merge($this->flop, [$this->turn], [$this->river], $this->seats[0]->hand);

        (new HandEvaluatorService)->evaluateHand($cards, $this->config['card'], $this->config['suit']);
    }
}