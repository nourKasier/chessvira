<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateReadinessAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($matchId, $userColor, $readiness)
    {
        $chessMatch = ChessMatch::where('id', $matchId)->first();
        if (!$chessMatch) {
            throw new \Exception('Match not found', 404);
        }
        if ($userColor === "white") {
            $chessMatch->player1_ready = $readiness;
        } else if ($userColor === "black") {
            $chessMatch->player2_ready = $readiness;
        }
        $chessMatch->save();
        return ['message' => 'Readiness updated successfully', 'code' => 200];
    }
}
