<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = ['SMP-MA'];
        foreach ($schedules as $item) {
            Schedule::create([
                'name' => $item,
            ]);
        }
    }
}
