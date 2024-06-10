<?php

namespace App\Livewire\Admin\Absensi;

use App\Exports\DetailAbsenSiswa as ExportsDetailAbsenSiswa;
use App\Models\Absensiswa;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class DetailAbsenSiswa extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Detail Absen Siswa/Santri')]

    public $student_id;

    public $startDate;
    public $endDate;

    public $studentName;

    public function mount($student_id)
    {
        $this->student_id = $student_id;

        $this->studentName = Student::findOrFail($student_id)->name;

        $this->startDate = Carbon::now()->subDays(7)->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }

    public function render()
    {
        $absens = $this->getAbsen();
        return view('livewire.admin.absensi.detail-absen-siswa', compact('absens'));
    }

    public function getAbsen()
    {

        $absens = Absensiswa::where('student_id', $this->student_id)
            ->whereBetween(\DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate])
            ->with(['absensekolah.user', 'absensekolah.mapel', 'student'])
            ->take(30)
            ->get();

        return $absens;
    }

    public function unduhExcel()
    {
        $filename = 'Detail Kehadiran Siswa ' . date('Y-m-d H_i_s') . '.xls';

        $models = $this->getAbsen();
        return Excel::download(new ExportsDetailAbsenSiswa($models, $this->studentName), $filename);
    }
}
