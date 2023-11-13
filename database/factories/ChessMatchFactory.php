<?php

namespace Database\Factories;

use App\ChessMatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\ChessMatch>
 */
class ChessMatchFactory extends Factory
{
    protected $model = ChessMatch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // return [
        //     'pgn' => '',
        // ];
        return [
            'white_player_id' => $this->faker->numberBetween(1, 100),
            'black_player_id' => $this->faker->numberBetween(1, 100),
            'pgn' => $this->faker->text(50),
        ];
    }
}
