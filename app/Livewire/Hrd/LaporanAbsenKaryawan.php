<?php

namespace App\Livewire\Hrd;

use App\Exports\LaporanAbsenKaryawanexport;
use App\Models\Absenkaryawan;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
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
        // $absens = Absenkaryawan::all();

        $absens = Absenkaryawan::with(['absenkaryawandetails' => function ($query) {
            $query->whereDoesntHave('absendinasluar')
                ->orWhereHas('absendinasluar', function ($subQuery) {
                    $subQuery->where('approval', true);
                });;
        }])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->paginate($this->perPage);
        return view('livewire.hrd.laporan-absen-karyawan', [
            'absens' => $absens,
        ]);

    }

    public function unduhExcel()
    {
        $filename = 'Absen Karyawan ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new LaporanAbsenKaryawanexport($this->startDate, $this->endDate), $filename);
    }
}
