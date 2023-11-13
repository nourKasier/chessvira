<?php

namespace Database\Factories;

use App\Lobby;
use Domain\Client\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Lobby>
 */
class LobbyFactory extends Factory
{
    protected $model = Lobby::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player1_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => 'waiting',
        ];
    }
}
