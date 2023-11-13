<?php

namespace Database\Seeders;

use App\Lobby;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Lobby::factory()->count(10)->create();
    }
}
