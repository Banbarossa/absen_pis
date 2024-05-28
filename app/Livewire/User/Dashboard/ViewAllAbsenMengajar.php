<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absensekolah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ViewAllAbsenMengajar extends Component
{

    public $startDate;
    public $endDate;

    #[Layout('layouts.user-layout')]
    #[Title('Riwayat Absen mengajar')]

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }
    public function render()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->format('H:i:s');

        $absens = Absensekolah::with('complainmengajar', 'rombel', 'mapel')
            ->where('user_id', $user->id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
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
            ->get();

        return view('livewire.user.dashboard.view-all-absen-mengajar', compact('absens', 'today'));

    }
}
