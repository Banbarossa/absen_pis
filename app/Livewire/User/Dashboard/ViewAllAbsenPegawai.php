<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenkaryawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ViewAllAbsenPegawai extends Component
{

    #[Layout('layouts.user-layout')]
    #[Title('Riwayat Absen')]

    public $startDate;
    public $endDate;

    public function render()
    {

        $user = Auth::user();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfDay();
        $absen = Absenkaryawan::with('absenkaryawandetails')
            ->where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $absen->each(function ($item) {
            $item->masuk_1 = $item->absenkaryawandetails->where('type', 'masuk_1')->first();
            $item->masuk_2 = $item->absenkaryawandetails->where('type', 'masuk_2')->first();
            $item->pulang = $item->absenkaryawandetails->where('type', 'pulang')->first();
        });
        return view('livewire.user.dashboard.view-all-absen-pegawai', compact('absen'));
    }
}
