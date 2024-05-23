<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenkaryawan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Karyawan extends Component
{
    public function render()
    {
        $user = Auth::loginUsingId(36);
        $absen = Absenkaryawan::where('user_id', $user->id)->get();
        return view('livewire.user.dashboard.karyawan', compact('absen'));
    }
}
