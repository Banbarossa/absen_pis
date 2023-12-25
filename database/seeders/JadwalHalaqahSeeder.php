<?php

namespace Database\Seeders;

use App\Models\JadwalHalaqah;
use Illuminate\Database\Seeder;

class JadwalHalaqahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'hari' => 2,
                'nama_sesi' => 'subuh',
                'mulai_absen' => '05:30',
                'akhir_absen' => '06:30',
                'insentif' => 10000,
            ],
            [
                'hari' => 2,
                'nama_sesi' => 'maqhrib',
                'mulai_absen' => '19:00',
                'akhir_absen' => '20:00',
                'insentif' => 10000,
            ],
            [
                'hari' => 3,
                'nama_sesi' => 'subuh',
                'mulai_absen' => '05:30',
                'akhir_absen' => '06:30',
                'insentif' => 10000,
            ],
            [
                'hari' => 3,
                'nama_sesi' => 'maqhrib',
                'mulai_absen' => '19:00',
                'akhir_absen' => '20:00',
                'insentif' => 10000,
            ],
            [
                'hari' => 4,
                'nama_sesi' => 'subuh',
                'mulai_absen' => '05:30',
                'akhir_absen' => '06:30',
                'insentif' => 10000,
            ],
            [
                'hari' => 4,
                'nama_sesi' => 'maqhrib',
                'mulai_absen' => '14:00',
                'akhir_absen' => '20:00',
                'insentif' => 10000,
            ],
            [
                'hari' => 5,
                'nama_sesi' => 'subuh',
                'mulai_absen' => '05:30',
                'akhir_absen' => '06:30',
                'insentif' => 10000,
            ],
            [
                'hari' => 5,
                'nama_sesi' => 'maqhrib',
                'mulai_absen' => '14:00',
                'akhir_absen' => '20:00',
                'insentif' => 10000,
            ],
            [
                'hari' => 6,
                'nama_sesi' => 'subuh',
                'mulai_absen' => '05:30',
                'akhir_absen' => '06:30',
                'insentif' => 10000,
            ],
        ];

        foreach ($data as $item) {
            JadwalHalaqah::create($item);
        }
    }
}
