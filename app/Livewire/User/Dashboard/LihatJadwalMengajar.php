<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Roster;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class LihatJadwalMengajar extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Jadwal Mengajar')]
    public function render()
    {

        $semesterAktif = Semester::whereStatus(1)->first();
        $rosters = Roster::with('jammengajar', 'mapel', 'rombel')
            ->leftjoin('jammengajars', 'rosters.jammengajar_id', '=', 'jammengajars.id')
            ->where('user_id', Auth::user()->id)
            ->where('semester_id', $semesterAktif->id)
            ->orderBy('jammengajars.hari', 'asc')
            ->orderBy('jammengajars.jam_ke', 'asc')
            ->get()
            ->groupBy('jammengajar.hari');

        $now = Carbon::now()->format('H:i:s');

        $today = Carbon::now()->weekday();

        return view('livewire.user.dashboard.lihat-jadwal-mengajar', compact('semesterAktif', 'rosters', 'now', 'today'));
    }
}
