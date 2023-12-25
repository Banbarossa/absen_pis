<?php

namespace App\Livewire\Hrd;

use App\Exports\KaryawanReport;
use App\Models\Absenkaryawan;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class LaporanAbsenKaryawan extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 15;

    public $startDate, $endDate;

    public function mount()
    {
        $today = Carbon::now();

        $this->startDate = $today->startOfMonth()->toDateString();
        $this->endDate = $today->toDateString();
    }

    public function render()
    {

        $absens = Absenkaryawan::whereBetween('tanggal', [$this->startDate, $this->endDate])->paginate($this->perPage);

        return view('livewire.hrd.laporan-absen-karyawan', [
            'absens' => $absens,
        ])->layout('layouts.app');

    }

    public function unduhExcel()
    {
        return Excel::download(new KaryawanReport($this->startDate, $this->endDate), 'Laporan karyawan.xlsx');
    }
}
