<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenhalaqah;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ViewAllAbsenHalaqah extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('absen Halaqah')]

    public function render()
    {
        $absen = Absenhalaqah::latest()->take(5)->get();
        return view('livewire.user.dashboard.view-all-absen-halaqah');
    }
}
