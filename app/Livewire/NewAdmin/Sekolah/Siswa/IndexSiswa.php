<?php

namespace App\Livewire\NewAdmin\Sekolah\Siswa;

use App\Exports\StudentExport;
use App\Models\Student;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IndexSiswa extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Layout('layouts.user-layout')]
    #[Title('Daftar Siswa')]

    public $search;
    public function render()
    {

        $students = Student::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->orderBy('name', 'asc')->paginate(30);

        return view('livewire.new-admin.sekolah.siswa.index-siswa', compact('students'));

    }

    public function unduhExcel()
    {
        $filename = 'Daftar Siswa ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new StudentExport(), $filename);
    }

    public function changeStatus($id)
    {
        $student = Student::findOrFail($id);
        $student->status = !$student->status;
        $student->save();

        $this->alert('success', 'Keaktifan siswa berhasil diperbaharui');

    }
}
