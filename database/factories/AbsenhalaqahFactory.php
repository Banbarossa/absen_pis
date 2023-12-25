<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absenhalaqah>
 */
class AbsenhalaqahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $randomUserId = random_int(1, 10);

        // random halaqah id
        $JadwalHalaqahCount = DB::table('jadwal_halaqahs')->count();
        $randomjawalHalaqahId = random_int(1, $JadwalHalaqahCount);

        return [
            'user_id' => $randomUserId,
            'jadwal_halaqah_id' => $randomjawalHalaqahId,
            'tanggal' => $this->faker->dateTimeBetween('2023-11-01', '2023-11-30')->format('Y-m-d'),
            'waktu_absen' => $this->faker->time(),
            'kehadiran' => $this->faker->randomElement(['hadir', 'izin dinas', 'izin pribadi', 'sakit', 'alpa']),
            'created_by' => $randomUserId,
            'in_location' => $this->faker->boolean,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'image' => $this->faker->imageUrl(),
        ];

    }
}
