<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapels = ['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika', 'biologi', 'IPS Terpadu', 'Olahraga', 'Bahasa Arab', 'PPKN', 'tauhid', 'sejarah', 'geografi', 'ekonomi', 'tik', 'fikih'];
        foreach ($mapels as $mapel) {
            Mapel::create([
                'mata_pelajaran' => $mapel,
            ]);
        }
    }
}
