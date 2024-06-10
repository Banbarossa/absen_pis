<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');

        $models = Student::whereStatus(true)->orderBy('name', 'asc')->get();
        return view('export.student', compact('time_download', 'models'));
    }
}
