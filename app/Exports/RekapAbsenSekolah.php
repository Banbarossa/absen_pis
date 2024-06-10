<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapAbsenSekolah implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $models;
    public $periode;
    public $jenjang;

    public function __construct($models, $periode, $jenjang)
    {
        $this->models = $models;
        $this->periode = $periode;
        $this->jenjang = $jenjang;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');
        $models = $this->models;
        $periode = $this->periode;
        $jenjang = $this->jenjang;
        return view('export.rekap-absen-sekolah', compact('time_download', 'models', 'periode', 'jenjang'));
    }
}
