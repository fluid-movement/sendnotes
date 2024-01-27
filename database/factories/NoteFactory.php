<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'send_date' => $this->faker->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
            'is_published' => $this->faker->boolean,
            'recipient' => $this->faker->email,
        ];
    }
}
