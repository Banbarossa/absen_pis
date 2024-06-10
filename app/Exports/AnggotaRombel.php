<?php

namespace App\Exports;

use App\Models\AnggotaKelas;
use App\Models\Rombel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnggotaRombel implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $rombel_id;

    public $semester_id;

    public function __construct($rombel_id, $semester_id)
    {
        $this->rombel_id = $rombel_id;
        $this->semester_id = $semester_id;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');

        $models = AnggotaKelas::with('student')->where('semester_id', $this->semester_id)
            ->where('rombel_id', $this->rombel_id)->get();

        $rombelName = Rombel::findOrFail($this->rombel_id)->nama_rombel;

        return view('export.anggotaRombel', compact('time_download', 'models', 'rombelName'));
    }
}
