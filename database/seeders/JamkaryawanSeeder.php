<?php

namespace Database\Seeders;

use App\Models\Jamkaryawan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JamkaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_jam_kerja' => 'kesantrian 1',
                'jam_masuk' => Carbon::createFromFormat('H:i', '18:00')->format('H:i'),
                'jam_pulang' => Carbon::createFromFormat('H:i', '21:59')->format('H:i'),

                'mulai_absen_masuk' => Carbon::createFromFormat('H:i', '17:45')->format('H:i'),
                'akhir_absen_masuk' => Carbon::createFromFormat('H:i', '19:30')->format('H:i'),
                'mulai_absen_pulang' => Carbon::createFromFormat('H:i', '21:40')->format('H:i'),
                'akhir_absen_pulang' => Carbon::createFromFormat('H:i', '21:59')->format('H:i'),
                'toleransi' => 10,

            ],
            [
                'nama_jam_kerja' => 'kesantrian 2',
                'jam_masuk' => Carbon::createFromFormat('H:i', '22:00')->format('H:i'),
                'jam_pulang' => Carbon::createFromFormat('H:i', '07:30')->format('H:i'),

                'mulai_absen_masuk' => Carbon::createFromFormat('H:i', '22:00')->format('H:i'),
                'akhir_absen_masuk' => Carbon::createFromFormat('H:i', '23:30')->format('H:i'),
                'mulai_absen_pulang' => Carbon::createFromFormat('H:i', '07:15')->format('H:i'),
                'akhir_absen_pulang' => Carbon::createFromFormat('H:i', '08:00')->format('H:i'),
                'toleransi' => 10,
            ],
        ];

        foreach ($data as $item) {
            Jamkaryawan::create($item);
        }
    }
}
