<?php

namespace Database\Seeders;

use App\Models\Rombel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $rombels = [
            // [
            //     'sekolah_id' => 1,
            //     'nama_rombel' => '1 SD',
            //     'tingkat_kelas' => 1,
            //     'latitude' => 5.464304,
            //     'longitude' => 95.386500,
            //     'radius' => 1000,
            // ],
            // [
            //     'sekolah_id' => 1,
            //     'nama_rombel' => '2 SD',
            //     'tingkat_kelas' => 2,
            //     'latitude' => 5.464304,
            //     'longitude' => 95.386500,
            //     'radius' => 1000,
            // ],
            // [
            //     'sekolah_id' => 1,
            //     'nama_rombel' => '3 SD',
            //     'tingkat_kelas' => 3,
            //     'latitude' => 5.464304,
            //     'longitude' => 95.386500,
            //     'radius' => 1000,
            // ],
            // [
            //     'sekolah_id' => 1,
            //     'nama_rombel' => '4 SD',
            //     'tingkat_kelas' => 4,
            //     'latitude' => 5.464304,
            //     'longitude' => 95.386500,
            //     'radius' => 1000,
            // ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '7-1',
                'tingkat_kelas' => 7,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '7-2',
                'tingkat_kelas' => 7,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '8-1',
                'tingkat_kelas' => 8,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '8-2',
                'tingkat_kelas' => 8,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '9-1',
                'tingkat_kelas' => 9,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '9-2',
                'tingkat_kelas' => 9,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 2,
                'nama_rombel' => '10-Agama',
                'tingkat_kelas' => 10,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 3,
                'nama_rombel' => '10-MIPA',
                'tingkat_kelas' => 10,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 3,
                'nama_rombel' => '11-Agama',
                'tingkat_kelas' => 11,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 3,
                'nama_rombel' => '11-MIPA',
                'tingkat_kelas' => 11,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 3,
                'nama_rombel' => '12-Agama',
                'tingkat_kelas' => 12,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
            [
                'sekolah_id' => 3,
                'nama_rombel' => '12-MIPA',
                'tingkat_kelas' => 12,
                'latitude' => 5.464304,
                'longitude' => 95.386500,
                'radius' => 1000,
            ],
        ];

        foreach ($rombels as $rombelData) {
            $rombelData['kode_rombel'] = Str::uuid();
            Rombel::create($rombelData);
        }

    }
}
