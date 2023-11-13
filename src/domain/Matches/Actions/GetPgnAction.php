<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPgnAction
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
        $pgn = $chessMatch->pgn;
        $player1Time = $chessMatch->player1_time;
        $player2Time = $chessMatch->player2_time;
        return ['pgn' => $pgn, 'player1Time' => $player1Time, 'player2Time' => $player2Time];
    }
}
