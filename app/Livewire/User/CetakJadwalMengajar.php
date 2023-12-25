<?php

namespace App\Livewire\User;

use App\Models\Roster;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CetakJadwalMengajar extends Component
{

    public $userName, $semester, $tahun_ajaran;

    public function mount()
    {
        $semesterAktif = Semester::whereStatus('1')->first();
        $this->userName = Auth::user()->name;
        $this->semester = $semesterAktif->nama_semester;
        $this->tahun_ajaran = $semesterAktif->tahun;
    }
    public function render()
    {
        $semesterAktif = Semester::whereStatus(1)->first();
        $roster = Roster::with('jammengajar', 'mapel')->where('user_id', Auth::user()->id)->where('semester_id', $semesterAktif->id)->get();

        // dd($roster);
        return view('livewire.user.cetak-jadwal-mengajar', ['rosters' => $roster])->layout('layouts.app');
    }
}
