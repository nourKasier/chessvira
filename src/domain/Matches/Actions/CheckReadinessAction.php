<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckReadinessAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($matchId)
    {
        $chessMatch = ChessMatch::where('id', $matchId)->first();

        if (!$chessMatch) {
            throw new \Exception('Match not found', 404);
        }

        if ($chessMatch->player1_ready && $chessMatch->player2_ready) {
            $chessMatch->initial_time = now();
            $chessMatch->save();
            return ['playersReady' => true];
        }

        return ['playersReady' => false];
    }
}
