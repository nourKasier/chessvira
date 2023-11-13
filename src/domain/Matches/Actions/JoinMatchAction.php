<?php

namespace Domain\Matches\Actions;

use App\ChessMatch;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinMatchAction
{
    use AsAction;

    public function  __construct()
    {
        //
    }

    public function handle($id)
    {
        $match = ChessMatch::findOrFail($id);
        // Check if the second player has already joined
        if ($match->black_player_id) {
            // Redirect to the match show page
            return redirect()->route('match.show', ['id' => $match->id]);
        }

        // Assign the second player to the match
        $match->black_player_id = auth()->user()->id;
        $match->save();

        // Redirect to the match show page after a brief delay
        return redirect()->route('match.show', ['id' => $match->id])->with('joined', true);
    }
}
