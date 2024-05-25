<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenkaryawan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Karyawan extends Component
{
    public function render()
    {
        $user = Auth::user();
        $absen = Absenkaryawan::with(['absenkaryawandetails' => function ($query) {
            $query->whereIn('type', ['masuk_1', 'masuk_2', 'pulang']);
        }])
            ->where('user_id', $user->id)
            ->latest()->take(2)->get();

        $absen->each(function ($item) {
            $item->masuk_1 = $item->absenkaryawandetails->where('type', 'masuk_1')->first();
            $item->masuk_2 = $item->absenkaryawandetails->where('type', 'masuk_2')->first();
            $item->pulang = $item->absenkaryawandetails->where('type', 'pulang')->first();
        });

        return view('livewire.user.dashboard.karyawan', compact('absen'));
    }
}
