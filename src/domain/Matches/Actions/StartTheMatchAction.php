<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use App\Lobby;
use Lorisleiva\Actions\Concerns\AsAction;

class StartTheMatchAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($current_user_id)
    {
        // Check if there is a waiting lobby
        $waitingLobby = Lobby::where('status', 'waiting')->where('player1_id', '<>', $current_user_id)->orderBy('created_at')->first();

        if ($waitingLobby) {
            // Assign colors randomly
            $colors = ['white', 'black'];
            shuffle($colors);

            // Update the waiting lobby status and assign the current user as the second player
            $waitingLobby->status = 'playing';
            $waitingLobby->player2_id = $current_user_id;
            $waitingLobby->save();

            // Create a match record
            $match = new ChessMatch();
            $match->white_player_id = $colors[0] === 'white' ? $waitingLobby->player1_id : $waitingLobby->player2_id;
            $match->black_player_id = $colors[0] === 'black' ? $waitingLobby->player1_id : $waitingLobby->player2_id;
            $match->initial_time = now();
            $match->player1_time = 600;
            $match->player2_time = 600;
            $match->save();
            session()->put('userColor', $colors[1]);
            // Redirect to the match page with the match ID and user color
            return ['redirectTo' => 'match', 'matchId' => $match->id, 'color' => $colors[1]];
        }

        // If no lobby found, delete previous lobbies of this player
        $lobbies = Lobby::where('player1_id', 1)->get();
        foreach ($lobbies as $lobby) {
            $lobby->delete();
        }
        // If no lobby found, create a new lobby and wait for another player
        $lobby = new Lobby();
        $lobby->player1_id = $current_user_id;
        $lobby->status = 'waiting';
        $lobby->save();

        return ['redirectTo' => 'lobby'];
    }
}
