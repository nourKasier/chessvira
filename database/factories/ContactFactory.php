<?php

namespace Database\Factories;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
