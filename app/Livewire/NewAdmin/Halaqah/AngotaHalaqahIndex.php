<?php

namespace App\Livewire\NewAdmin\Halaqah;

use App\Models\Anggotahalaqah;
use App\Models\Groupinghalaqah;
use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AngotaHalaqahIndex extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Anggota Kelas/Rombel ')]

    public Groupinghalaqah $group;

    public $search;

    public function render()
    {

        $anggota = Anggotahalaqah::with('student')
            ->where('groupinghalaqah_id', $this->group->id)
            ->join('students', 'students.id', '=', 'anggotahalaqahs.student_id')
            ->orderBy('students.name')
            ->select('anggotahalaqahs.id as anggota_halaqah_id', 'anggotahalaqahs.*', 'students.*')
            ->when($this->search, function ($query) {
                $query->where('students.name', 'like', '%' . $this->search . '%');
            })
            ->get();

        $students = Student::orderBy('name', 'asc')
            ->whereDoesntHave('anggotahalaqah')
            ->where('status', true)
            ->get();
        return view('livewire.new-admin.halaqah.angota-halaqah-index', compact('anggota', 'students'));
    }

    public function addStudenToRombel($id)
    {

        Anggotahalaqah::create([
            'student_id' => $id,
            'groupinghalaqah_id' => $this->group->id,
        ]);
        $this->dispatch('addedSiswa');

    }

    public function hapusAnggotaRombel($id)
    {

        Anggotahalaqah::findOrFail($id)->delete();

    }
}
