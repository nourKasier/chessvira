<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Lorisleiva\Actions\Concerns\AsAction;

class GetInitialPositionAction
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

        // Retrieve the initial position from the `pgn` column of the $chessMatch model
        $initialPosition = $chessMatch->pgn;
        return ['initialPosition' => $initialPosition];
    }
}
