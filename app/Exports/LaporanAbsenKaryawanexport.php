<?php

namespace App\Exports;

use App\Models\Absenkaryawan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanAbsenKaryawanexport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $startDate;
    public $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');
        $models = Absenkaryawan::with('absenkaryawandetails', 'bagianuser.jamkaryawans')->whereBetween('tanggal', [$this->startDate, $this->endDate])->get();

        return view('export.laporan-absen-karyawan', compact('time_download', 'models'));
    }
}
