<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use App\Lobby;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckGameStatusAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle()
    {
        $userId = auth()->user()->id;
        $lobby = Lobby::where('player1_id', $userId)->latest('created_at')->first();
        $matchId = null;
        $userColor = null;
        if ($lobby->player2_id !== null) {
            $secondPlayerJoined = true;
            $match = ChessMatch::where('white_player_id', $userId)
                ->orWhere('black_player_id', $userId)
                ->latest('created_at')
                ->first();
            if ($match->white_player_id === $userId) {
                $userColor = "white";
            } else if ($match->black_player_id === $userId) {
                $userColor = "black";
            }
            if ($userColor === "white" || $userColor === "black") {
                session()->put('userColor', $userColor);
            }
            $matchId = $match->id;
        } else {
            $secondPlayerJoined = false;
            $matchId = null;
        }
        return [
            'secondPlayerJoined' => $secondPlayerJoined,
            'matchId' => $matchId,
            'userColor' => $userColor,
        ];
    }
}
