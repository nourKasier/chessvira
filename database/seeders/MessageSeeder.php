<?php

namespace Database\Seeders;

use App\ChessMatch;
use App\Message;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chessMatches = ChessMatch::all();

        foreach ($chessMatches as $chessMatch) {
            $users = $chessMatch->whitePlayer->id < $chessMatch->blackPlayer->id ? [$chessMatch->whitePlayer, $chessMatch->blackPlayer] : [$chessMatch->blackPlayer, $chessMatch->whitePlayer];

            for ($i = 0; $i < 10; $i++) {
                Message::factory()->create([
                    'user_id' => $users[$i % 2]->id,
                    'match_id' => $chessMatch->id,
                ]);
            }
        }
    }
}
