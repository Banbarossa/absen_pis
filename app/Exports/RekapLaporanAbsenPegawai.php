<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapLaporanAbsenPegawai implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $models;
    public $periode;

    public function __construct($models, $periode)
    {
        $this->models = $models;
        $this->periode = $periode;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');
        $models = $this->models;
        $periode = $this->periode;
        return view('export.rekap-absen-pegawai', compact('models', 'time_download', 'periode'));
    }
}
