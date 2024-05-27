<?php

namespace App\Livewire\Hrd\DetailLaporan;

use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class AbsenKaryawanDetail extends Component
{

    public $startDate;
    public $endDate;

    public $userId;

    public function mount($startDate, $endDate, $userId)
    {

        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;

    }

    public function render()
    {

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $models = \App\Models\AbsenKaryawan::with(['absenkaryawandetails' => function ($query) {
            $query->whereDoesntHave('absendinasluar')
                ->orWhereHas('absendinasluar', function ($subquery) {
                    $subquery->where('approval', true);
                });
        }])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('user_id', $this->userId)
            ->get();

        return view('livewire.hrd.detail-laporan.absen-karyawan-detail', compact('models'));
    }

    #[On('useridChange')]
    public function updateUserId($userId)
    {
        $this->userId = $userId;
    }
    #[On('startdateChange')]
    public function updatestartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    #[On('enddateChange')]
    public function updateendDate($endDate)
    {
        $this->endDate = $endDate;
    }
}
