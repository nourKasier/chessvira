<?php

namespace Database\Seeders;

use App\ChessMatch;
use Domain\Client\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChessMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChessMatch::factory()
            ->count(100)
            ->create();
        // $users = User::all();

        // foreach ($users as $user) {
        //     $opponent = $users->where('id', '!=', $user->id)->random();

        //     ChessMatch::factory()->create([
        //         'white_player_id' => $user->id,
        //         'black_player_id' => $opponent->id,
        //     ]);
        // }
    }
}
