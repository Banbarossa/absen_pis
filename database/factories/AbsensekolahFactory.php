<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensekolah>
 */
class AbsensekolahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'tanggal' => $this->faker->dateTimeBetween('2023-11-01', '2023-11-30')->format('Y-m-d'),
            'jam_ke' => $this->faker->numberBetween(1, 4),
            'mulai_kbm' => $this->faker->time('H:i:s'),
            'akhir_kbm' => $this->faker->time('H:i:s'),
            'rombel_id' => $this->faker->numberBetween(1, 12),
            'sekolah_id' => $this->faker->numberBetween(1, 3),
            'mapel_id' => $this->faker->numberBetween(1, 12),
            'waktu_absen' => $this->faker->time('H:i:s'),
            'keterlambatan' => $this->faker->numberBetween(1, 60),
            'kehadiran' => $this->faker->randomElement(['hadir', 'izin dinas', 'izin pribadi', 'sakit', 'alpa']),
            'in_location' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'jumlah_jam' => 2,
            'image' => $this->faker->imageUrl(),
        ];
    }
}
