<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rombel>
 */
class RombelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_rombel' => Str::uuid(),
            'sekolah_id' => $this->faker->numberBetween(1, 2),
            'nama_rombel' => $this->faker->name(),
            'tingkat_kelas' => $this->faker->numberBetween(7, 12),
        ];
    }
}
