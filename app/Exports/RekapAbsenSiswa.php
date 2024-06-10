<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapAbsenSiswa implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public $models;

    public function __construct($models)
    {
        $this->models = $models;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');
        $models = $this->models;
        return view('export.rekap-absen-siswa', compact('time_download', 'models'));
    }
}
