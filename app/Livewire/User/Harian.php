<?php

namespace App\Livewire\User;

use App\Models\Absenkaryawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Harian extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 30;

    public $startDate, $endDate;

    #[Layout('layouts.app')]
    #[Title('Laporan Absen Karyawan')]

    public function mount()
    {
        $today = Carbon::now();

        $this->startDate = $today->copy()->startOfMonth()->toDateString();
        $this->endDate = $today->toDateString();
    }

    public function render()
    {
        $absens = Absenkaryawan::with('absenkaryawandetails')
            ->where('user_id', Auth::user()->id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])->orderBy('tanggal', 'desc')
            ->paginate($this->perPage);
        return view('livewire.user.harian', compact('absens'));
    }
}
