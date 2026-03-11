<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'status' => fake()->randomElement(['pending', 'complete']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'due_date' => fake()->date('Y-m-d'),
            'user_id' => fake()->randomNumber(1, 99),
        ];
    }
}
