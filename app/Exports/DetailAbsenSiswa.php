<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DetailAbsenSiswa implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $models;
    public $studentName;

    public function __construct($models, $studentName)
    {
        $this->models = $models;
        $this->studentName = $studentName;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');
        $models = $this->models;
        $studentName = $this->studentName;
        return view('export.detail-absen-siswa', compact('time_download', 'models', 'studentName'));
    }
}
