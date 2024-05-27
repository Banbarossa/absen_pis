<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenhalaqah;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LatestAbsenHalaqah extends Component
{
    public function render()
    {

        $user = Auth::user();
        $absens = Absenhalaqah::with('jadwalhalaqah', 'complainhalaqah')->where('user_id', $user->id)->latest()->take(7)->get();

        return view('livewire.user.dashboard.latest-absen-halaqah', compact('absens'));
    }
}
