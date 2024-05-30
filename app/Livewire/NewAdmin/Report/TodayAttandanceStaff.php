<?php

namespace App\Livewire\NewAdmin\Report;

use App\Models\Absenkaryawan;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TodayAttandanceStaff extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Kehadiran Pegawai')]
    public function render()
    {

        $today = Carbon::now()->toDateString();
        $absen = Absenkaryawan::with('absenkaryawandetails', 'user')
            ->whereDate('tanggal', $today)
            ->join('users', 'absenkaryawans.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('absenkaryawans.*', 'users.name as user_name')
            ->get();

        $absen->each(function ($item) {
            $item->masuk_1 = $item->absenkaryawandetails->where('type', 'masuk_1')->first();
            $item->masuk_2 = $item->absenkaryawandetails->where('type', 'masuk_2')->first();
            $item->pulang = $item->absenkaryawandetails->where('type', 'pulang')->first();
        });
        return view('livewire.new-admin.report.today-attandance-staff', compact('absen'));
    }
}
