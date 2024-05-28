<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenhalaqah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ViewAllAbsenHalaqah extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Riwayat Absen Halaqah')]

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }

    public function render()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->format('H:i;s');
        $absens = Absenhalaqah::with('jadwalhalaqah', 'complainhalaqah')
            ->where('user_id', $user->id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->where(function ($query) use ($today, $now) {
                $query->whereDate('tanggal', '<>', $today)
                    ->orWhere(function ($subquery) use ($today, $now) {
                        $subquery->whereDate('tanggal', $today)
                            ->whereHas('jadwalhalaqah', function ($q) use ($now) {
                                $q->where('mulai_absen', '<=', $now);
                            });
                    });
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $today = Carbon::now()->toDateString();

        return view('livewire.user.dashboard.view-all-absen-halaqah', compact('today', 'absens', 'now'));
    }
}
