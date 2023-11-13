<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class GetDisconnectionTimeAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($matchId, $userColor)
    {
        $chessMatch = ChessMatch::where('id', $matchId)->first();

        if (!$chessMatch) {
            throw new \Exception('Match not found', 404);
        }

        if ($chessMatch->player1_last_move_timestamp !== null && $chessMatch->player2_last_move_timestamp !== null) {
            $player1LastMove = Carbon::parse($chessMatch->player1_last_move_timestamp);
            $player2LastMove = Carbon::parse($chessMatch->player2_last_move_timestamp);
            $player1DisconnectionTime = Carbon::parse($chessMatch->player1_disconnection_time);
            $player2DisconnectionTime = Carbon::parse($chessMatch->player2_disconnection_time);

            if ($player1LastMove < $player2LastMove) {
                // Elapsed time occurred during the player's turn
                $player1LastMove = $chessMatch->player1_last_move_timestamp;
                $timeDifferenceInSeconds = now()->diffInSeconds($player1DisconnectionTime);
                $chessMatch->player1_time = $chessMatch->player1_time - $timeDifferenceInSeconds;
            } else if ($player2LastMove < $player1LastMove) {
                // Elapsed time occurred during the player's turn
                $player2LastMove = $chessMatch->player2_last_move_timestamp;
                $timeDifferenceInSeconds = now()->diffInSeconds($player2DisconnectionTime);
                $chessMatch->player2_time = $chessMatch->player2_time - $timeDifferenceInSeconds;
            }
            $chessMatch->initial_time = now();
            $chessMatch->save();
            $player1Time = $chessMatch->player1_time;
            $player2Time = $chessMatch->player2_time;
            // $moveData = [];
            // ChessMoveEvent::dispatch($moveData, $matchId, $player1Time, $player2Time);

            return ['player1Time' => $player1Time, 'player2Time' => $player2Time];
            // return response()->json(['player1Time' => $player1Time, 'player2Time' => $player2Time]);
        }
    }
}
