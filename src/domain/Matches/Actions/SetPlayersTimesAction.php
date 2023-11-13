<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Lorisleiva\Actions\Concerns\AsAction;

class SetPlayersTimesAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($matchId, $userColor, $player1TimeFromRequest, $player2TimeFromRequest)
    {
        $chessMatch = ChessMatch::where('id', $matchId)->first();
            if (!$chessMatch) {
                return response()->json(['error' => 'Match not found'], 404);
            }
            if ($userColor === 'white') {
                //player1Time for white player
                $player1Time = $player1TimeFromRequest;
                $player2Time = $player2TimeFromRequest;
            } else {
                //if black player made this request so the times should be reversed
                $player1Time = $player2TimeFromRequest;
                $player2Time = $player1TimeFromRequest;
            }
            $chessMatch->player1_time = $player1Time;
            $chessMatch->player2_time = $player2Time;
            $chessMatch->save();
            return ['success' => true, 'code' => 200];
    }
}
