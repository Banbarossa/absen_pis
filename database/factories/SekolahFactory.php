<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sekolah>
 */
class SekolahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'npsn' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'nama' => $this->faker->name,
            'user_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
