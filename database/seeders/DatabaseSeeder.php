<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\SecureLocationSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(40)->create();
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        // \App\Models\Sekolah::factory(3)->create();
        $this->call(SekolahSeeder::class);
        $this->call(RombelSeeder::class);
        // \App\Models\Rombel::factory(12)->create();

        $this->call(SemesterSeeder::class);
        $this->call(ScheduleSeeder::class);

        // \App\Models\Jammengajar::factory(100)->create();
        // $this->call(JammengajarSeeder::class);
        $this->call(MapelSeeder::class);

        $this->call(JadwalHalaqahSeeder::class);
        // \App\Models\Absenhalaqah::factory(100)->create();

        // $this->call(AksesabsenSeeder::class);

        // \App\Models\Absensekolah::factory(200)->create();
        // \App\Models\Absenhalaqah::factory(200)->create();

        $this->call(SecureLocationSeeder::class);

    }
}
