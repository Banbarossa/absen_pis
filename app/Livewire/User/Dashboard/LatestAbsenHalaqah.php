<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenhalaqah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LatestAbsenHalaqah extends Component
{
    public function render()
    {

        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->format('H:i;s');
        $absens = Absenhalaqah::with('jadwalhalaqah', 'complainhalaqah')
            ->where('user_id', $user->id)
            ->where(function ($query) use ($today, $now) {
                $query->whereDate('tanggal', '<>', $today)
                    ->orWhere(function ($subquery) use ($today, $now) {
                        $subquery->whereDate('tanggal', $today)
                            ->whereHas('jadwalhalaqah', function ($q) use ($now) {
                                $q->where('mulai_absen', '<=', $now);
                            });
                    });
            })
            ->latest()
            ->take(7)
            ->get();

        return view('livewire.user.dashboard.latest-absen-halaqah', compact('absens', 'today'));
    }
}
