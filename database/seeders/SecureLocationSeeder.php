<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SecureLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('secure_locations')->insert([
            [
                'nama_lokasi' => 'Lokasi A',
                'kode_lokasi' => Str::uuid(),
                'start_scan' => '08:00:00',
                'end_scan' => '16:00:00',
                'latitude' => -6.20000000,
                'longitude' => 106.81666667,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lokasi' => 'Lokasi B',
                'kode_lokasi' => Str::uuid(),
                'start_scan' => '09:00:00',
                'end_scan' => '17:00:00',
                'latitude' => -6.30000000,
                'longitude' => 106.90000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lokasi' => 'Lokasi C',
                'kode_lokasi' => Str::uuid(),
                'start_scan' => '07:30:00',
                'end_scan' => '15:30:00',
                'latitude' => -6.40000000,
                'longitude' => 106.70000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lokasi' => 'Lokasi D',
                'kode_lokasi' => Str::uuid(),
                'start_scan' => '08:30:00',
                'end_scan' => '16:30:00',
                'latitude' => -6.50000000,
                'longitude' => 106.60000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
