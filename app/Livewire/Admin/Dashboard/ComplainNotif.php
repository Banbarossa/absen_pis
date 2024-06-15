<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Absenalternatif;
use App\Models\Absendinasluar;
use App\Models\Complainhalaqah;
use App\Models\Complainmengajar;
use Livewire\Component;

class ComplainNotif extends Component
{
    public function render()
    {

        $jlh_halaqah = Complainhalaqah::whereStatus(null)->get()->count();
        $jlh_mengajar = Complainmengajar::whereStatus(null)->get()->count();
        $jlh_luardinas = Absendinasluar::whereApproval(null)->get()->count();
        $jlh_absen_alternatif = Absenalternatif::whereNull('approved')->count();

        return view('livewire.admin.dashboard.complain-notif', compact('jlh_halaqah', 'jlh_mengajar', 'jlh_luardinas', 'jlh_absen_alternatif'));
    }
}
