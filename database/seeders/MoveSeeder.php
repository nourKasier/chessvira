<?php

namespace Database\Seeders;

use App\ChessMatch;
use App\Move;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Move::factory()
            ->count(100)
            ->create();
        // $chessMatches = ChessMatch::all();

        // foreach ($chessMatches as $chessMatch) {
        //     $pgn = $chessMatch->pgn;

        //     if (!$pgn) {
        //         continue;
        //     }

        //     $moves = explode(' ', $pgn);
        //     $moveNumber = 1;

        //     foreach ($moves as $move) {
        //         if (strpos($move, '.') !== false) {
        //             $moveNumber = (int) $move;

        //             continue;
        //         }

        //         Move::factory()->create([
        //             'match_id' => $chessMatch->id,
        //             'number' => $moveNumber,
        //             'san' => $move,
        //         ]);

        //         $moveNumber++;
        //     }
        // }
    }
}
