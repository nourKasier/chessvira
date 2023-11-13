<?php

namespace Database\Factories;

use App\Move;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Move>
 */
class MoveFactory extends Factory
{
    protected $model = Move::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        // return [
        //     'number' => $this->faker->unique()->numberBetween(1, 100),
        //     'san' => $this->faker->randomElement(['e4', 'd4', 'Nf3', 'Nc3', 'f4', 'g3', 'Bb5', 'Be2', 'O-O']),
        // ];
        return [
            'match_id' => $this->faker->unique()->numberBetween(1, 100),
            'number' => $this->faker->numberBetween(1, 100),
            'san' => $this->faker->text(5),
        ];
    }
}
