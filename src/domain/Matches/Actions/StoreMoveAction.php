<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use App\Events\ChessMoveEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreMoveAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($pgn, $matchId, $move, $timeLeft, $opponentTimeLeft)
    {
        // Process the chess move and get the move data
        $moveData = $move;
        $moveData['pgn'] = $pgn;
        $moveData['timeLeft'] = $timeLeft;
        $moveData['opponentTimeLeft'] = $opponentTimeLeft;

        // Find the match by ID
        $match = ChessMatch::where('id', $matchId)->first();

        if (!$match) {
            throw new \Exception('Match not found', 404);
        }

        // Calculate the time difference
        // $currentTime = now();
        $match->initial_time = now();

        if ($move['color'] === "w") {
            $match->player1_time = $timeLeft;
            $match->player2_time = $opponentTimeLeft;
            $match->player1_last_move_timestamp = now();
        }
        if ($move['color'] === "b") {
            $match->player1_time = $opponentTimeLeft;
            $match->player2_time = $timeLeft;
            $match->player2_last_move_timestamp = now();
            $temp = $timeLeft;
            $timeLeft = $opponentTimeLeft;
            $opponentTimeLeft = $temp;
        }

        $match->save();
        ChessMoveEvent::dispatch($moveData, $matchId, $timeLeft, $opponentTimeLeft);

        // Check if the current user is a player in the match
        $userId = auth()->user()->id;
        if ($match->white_player_id !== $userId && $match->black_player_id !== $userId) {
            return response()->json(['error' => 'You are not a player in this match.'], 403);
        }

        // Update the pgn column with the new move
        $match->pgn = $pgn;
        $match->save();

        // return response()->json(['success' => true]);
        return ['success' => true];
    }
}
