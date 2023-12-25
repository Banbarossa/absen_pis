<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jammengajar>
 */
class JammengajarFactory extends Factory
{
    use HasFactory;
    protected $model = Jammengajar::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $faker = \Faker\Factory::create();
        $hariArray = ['1', '2', '3', '4', '5', '6'];

        foreach ($hariArray as $hari) {

            for ($jam_ke = 1; $jam_ke <= 4; $jam_ke++) {

                $mulai_kbm = Carbon::createFromTime(8, 0, 0)->addHours($jam_ke - 1);
                $akhir_kbm = $mulai_kbm->copy()->addHours(1);
                $mulai_absen = $mulai_kbm->copy()->subMinutes(10);
                $akhir_absen = $akhir_kbm->copy()->subMinutes(15);

                $jumlah_jam = 2;

                DB::table('jammengajars')->insert([
                    'schedule_id' => $faker->numberBetween(1, 3),
                    'hari' => $hari,
                    'jam_ke' => $jam_ke,
                    'mulai_kbm' => $mulai_kbm->format('H:i'),
                    'akhir_kbm' => $akhir_kbm->format('H:i'),
                    'mulai_absen' => $mulai_absen->format('H:i'),
                    'akhir_absen' => $akhir_absen->format('H:i'),
                    'jumlah_jam' => $jumlah_jam,
                ]);
            }
        }
    }
}
