<?php

namespace App\Livewire\User;

use App\Models\Absenkaryawandetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RiwayatAbsenPribadi extends Component
{
    public $jumlahtampil = 1;

    public function render()
    {

        $models = Absenkaryawandetail::whereHas('absenkaryawan', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->latest()->take(5)->get();

        // dd($models);
        return view('livewire.user.riwayat-absen-pribadi', compact('models'));
    }
}
