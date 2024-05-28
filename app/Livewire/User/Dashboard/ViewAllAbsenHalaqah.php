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
    #[Title('Absen Halaqah')]

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
        $absens = Absenhalaqah::with('jadwalhalaqah', 'complainhalaqah')
            ->where('user_id', $user->id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $today = Carbon::now()->toDateString();

        return view('livewire.user.dashboard.view-all-absen-halaqah', compact('today', 'absens'));
    }
}
