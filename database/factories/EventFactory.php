<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventStart = $this->faker->dateTimeBetween('2023-01-01', '2023-12-31');
        $randomDays = mt_rand(1, 10); // Menghasilkan angka acak antara 1 hingga 10

        $eventEnd = clone $eventStart;
        $eventEnd->modify('+' . $randomDays . ' days');

        return [
            'event_name' => $this->faker->sentence(3),
            'event_start' => $eventStart->format('Y-m-d'),
            'event_end' => $eventEnd->format('Y-m-d'),
        ];
    }
}
