<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absensekolah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LatestAbsenMengajar extends Component
{

    public function render()
    {
        $today = Carbon::now()->toDateString();

        $user = Auth::user();

        $now = Carbon::now()->format('H:i:s');

        $absenToday = Absensekolah::with('complainmengajar', 'rombel', 'mapel')
            ->where('user_id', $user->id)
            ->where(function ($query) use ($today, $now) {
                $query->whereDate('tanggal', '<>', $today)
                    ->orWhere(function ($query) use ($today, $now) {
                        $query->whereDate('tanggal', $today)
                            ->where(function ($query) use ($now) {
                                $query->where('mulai_kbm', '<=', $now)
                                    ->orWhere('waktu_absen', '<=', $now);
                            });
                    });
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_ke', 'desc')
            ->take(6)
            ->get();

        return view('livewire.user.dashboard.latest-absen-mengajar', compact('absenToday', 'today'));
    }
}
