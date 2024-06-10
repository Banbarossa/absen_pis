<?php

namespace App\Livewire\NewAdmin\Sekolah\Rombel;

use App\Models\AnggotaKelas;
use App\Models\Rombel;
use App\Traits\SemesterAktif;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class IndexRombel extends Component
{
    use SemesterAktif;
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Daftar Kelas/Rombel')]

    public $search;

    public function render()
    {
        $semester = $this->getSemesterAktif();
        $rombels = Rombel::with('sekolah')->orderBy('tingkat_kelas', 'asc')
            ->when($this->search, function ($query) {
                $query->where('nama_rombel', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_rombel', 'asc')
            ->get();

        foreach ($rombels as $rombel) {
            $count = AnggotaKelas::where('rombel_id', $rombel->id)->where('semester_id', $semester->id)->count();
            $rombel->jumlah = $count;
        }
        return view('livewire.new-admin.sekolah.rombel.index-rombel', compact('rombels'));
    }

    public function changeAkses($id)
    {
        $rombel = Rombel::findOrfail($id);

        $rombel->can_absen = !$rombel->can_absen;

        $rombel->save();

        $this->alert('success', 'Data berhasil di update');

    }

}
