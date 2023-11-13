<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Lorisleiva\Actions\Concerns\AsAction;

class SetDisconnectionTimeAction
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
        if ($userColor === "white") {
            $chessMatch->player2_disconnection_time = now();
        } else if ($userColor === "black") {
            $chessMatch->player1_disconnection_time = now();
        }
        $chessMatch->save();
        return ['success' => true, 'code' => 200];
    }
}
