<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JammengajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Array hari
        $hariArray = ['1', '2', '3', '4', '5', '6'];

        // Loop untuk setiap hari
        foreach ($hariArray as $hari) {
            // Loop untuk setiap jam
            for ($jam_ke = 1; $jam_ke <= 4; $jam_ke++) {
                // Tetapkan waktu mulai KBM dan hitung waktu lainnya
                $mulai_kbm = Carbon::createFromTime(8, 0, 0)->addHours($jam_ke - 1);
                $akhir_kbm = $mulai_kbm->copy()->addHours(1);
                $mulai_absen = $mulai_kbm->copy()->subMinutes(10);
                $akhir_absen = $akhir_kbm->copy()->subMinutes(15);

                // Tetapkan jumlah jam
                $jumlah_jam = 2;

                // Masukkan data ke dalam database
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
