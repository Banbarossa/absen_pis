<?php

namespace App\Livewire\User\ScanMengajarPkkps;

use App\Models\Absensekolah;
use App\Models\Roster;
use App\Models\User;
use App\Traits\SemesterAktif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

    use SemesterAktif;
    public function render()
    {
        $user = Auth::user();

        $semester = $this->getSemesterAktif();

        $absen = Absensekolah::where('user_id', $user->id)
            ->whereDate('tanggal', Carbon::now()->toDateString())
            ->where('mulai_kbm', '<=', Carbon::now()->format('H:i:s'))
            ->where('akhir_kbm', '>=', Carbon::now()->format('H:i:s'))
            ->first();
        $roster = null;
        if (!$absen) {
            $roster = Roster::with('jammengajar', 'rombel', 'mapel')
                ->where('user_id', $user->id)
                ->where('semester_id', $semester->id)
                ->whereHas('rombel', function ($query) {
                    $query->where('can_absen', true);
                })
                ->whereHas('jammengajar', function ($query) {
                    $query->where('hari', Carbon::now()->weekday())
                        ->where('mulai_kbm', '<=', Carbon::now()->format('H:i;s'))
                        ->where('akhir_kbm', '>', Carbon::now()->format('H:i:s'));
                })
                ->first();

        }

        return view('livewire.user.scan-mengajar-pkkps.index', compact('absen', 'roster'));
    }
}
