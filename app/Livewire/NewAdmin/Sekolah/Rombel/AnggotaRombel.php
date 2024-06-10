<?php

namespace App\Livewire\NewAdmin\Sekolah\Rombel;

use App\Exports\AnggotaRombel as ExportsAnggotaRombel;
use App\Models\AnggotaKelas;
use App\Models\Rombel;
use App\Models\Student;
use App\Traits\SemesterAktif;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class AnggotaRombel extends Component
{
    use LivewireAlert;

    use SemesterAktif;
    public $rombelName;

    #[Layout('layouts.user-layout')]
    #[Title('Anggota Kelas/Rombel ')]
    public $rombel;

    public $semester_id;

    public $search;

    public function mount($code)
    {

        $rombel = Rombel::where('kode_rombel', $code)->first();
        $this->rombelName = $rombel->nama_rombel;
        $this->rombel = $rombel;
        $this->semester_id = $this->getSemesterAktif()->id;

    }

    public function addStudenToRombel($id)
    {
        $semester_id = $this->semester_id;
        $rombel_id = $this->rombel->id;

        AnggotaKelas::create([
            'student_id' => $id,
            'semester_id' => $semester_id,
            'rombel_id' => $rombel_id,
        ]);
        $this->dispatch('addedSiswa');

    }

    public function hapusAnggotaRombel($id)
    {

        AnggotaKelas::findOrFail($id)->delete();

    }

    public function unduhExcel()
    {
        $filename = 'Anggota Kelas ' . $this->rombel->name . '_' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new ExportsAnggotaRombel($this->rombel->id, $this->semester_id), $filename);
    }

    public function render()
    {

        $semester = $this->getSemesterAktif();
        $rombel = $this->rombel;

        $anggotakelas = AnggotaKelas::with('student')->where('semester_id', $semester->id)
            ->join('students', 'students.id', '=', 'anggota_kelas.student_id')
            ->where('rombel_id', $this->rombel->id)
            ->orderBy('students.name')
            ->select('anggota_kelas.id as anggota_kelas_id', 'anggota_kelas.*', 'students.*')
            ->when($this->search, function ($query) {
                $query->where('students.name', 'like', '%' . $this->search . '%');
            })
            ->get();

        $students = Student::orderBy('name', 'asc')
            ->whereDoesntHave('anggotakelas')
            ->where('status', true)
            ->orWhereHas('anggotakelas', function ($query) use ($semester, $rombel) {
                $query->where('rombel_id', '!=', $rombel->id)
                    ->where('semester_id', '!=', $semester->id);
            })
            ->get();
        return view('livewire.new-admin.sekolah.rombel.anggota-rombel', compact('anggotakelas', 'students'));
    }

}
