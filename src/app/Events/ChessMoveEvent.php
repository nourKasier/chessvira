<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChessMoveEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $moveData;
    public $player1Time;
    public $player2Time;
    protected $matchId;
    /**
     * Create a new event instance.
     */
    public function __construct($moveData, $matchId, $player1Time, $player2Time)
    {
        $this->moveData = $moveData;
        $this->matchId = $matchId;
        $this->player1Time = $player1Time;
        $this->player2Time = $player2Time;
        // $this->moveData = ['from' => 'A2', 'to' => 'A4'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chess-moves-' . $this->matchId),
        ];
    }
}
