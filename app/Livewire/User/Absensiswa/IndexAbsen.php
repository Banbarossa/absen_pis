<?php

namespace App\Livewire\User\Absensiswa;

use App\Models\Absensekolah;
use App\Models\AnggotaKelas;
use App\Models\Rombel;
use App\Traits\SemesterAktif;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class IndexAbsen extends Component
{
    use SemesterAktif;
    use LivewireAlert;

    #[Layout('layouts.user-layout')]
    #[Title('Absensi Siswa')]

    public $attendance = [];

    public Absensekolah $absen;

    public function render()
    {

        $semester_id = $this->getSemesterAktif()->id;
        $siswarombel = AnggotaKelas::where('semester_id', $semester_id)
            ->where('rombel_id', $this->absen->rombel_id)
            ->join('students', 'students.id', '=', 'anggota_kelas.student_id')
            ->orderBy('students.name', 'asc')
            ->select('students.*')
            ->get();

        foreach ($siswarombel as $item) {
            $this->attendance[$item->id] = 'h';
        }

        $rombelName = Rombel::findorFail($this->absen->rombel_id)->nama_rombel;
        return view('livewire.user.absensiswa.index-absen', compact('siswarombel', 'rombelName'));
    }

    public function store()
    {

        $validatedData = $this->validate([
            'attendance.*' => 'required|in:h,s,i,a',
        ]);

        foreach ($validatedData['attendance'] as $siswaId => $status) {
            \App\Models\Absensiswa::create([
                'student_id' => $siswaId,
                'rombel_id' => $this->absen->rombel_id,
                'absensekolah_id' => $this->absen->id,
                'status' => $status,
                'jumlah_jam' => $this->absen->jumlah_jam,
            ]);
        }

        $this->alert('success', 'Jazaakallahukhairan, Siswa udah berhasil di absen');
        return redirect()->route('v2.dashboard');
    }
}
