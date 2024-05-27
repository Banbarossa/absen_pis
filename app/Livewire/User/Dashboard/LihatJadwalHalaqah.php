<?php

namespace App\Livewire\User\Dashboard;

use App\Models\JadwalHalaqah;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class LihatJadwalHalaqah extends Component
{

    #[Layout('layouts.user-layout')]
    #[Title('Jadwal Halaqah')]
    public function render()
    {
        $rosters = JadwalHalaqah::orderBy('hari', 'asc')
            ->where('nama_sesi', '!=', 'khusus')
            ->where('is_aktif', true)
            ->orderBy('hari', 'asc')
            ->orderBy('nama_sesi', 'desc')
            ->get()
            ->groupBy('hari');

        $now = Carbon::now()->format('H:i:s');

        $today = Carbon::now()->weekday();

        return view('livewire.user.dashboard.lihat-jadwal-halaqah', compact('rosters', 'now', 'today'));
    }
}
