<?php

namespace App\Livewire\NewAdmin\Report;

use App\Models\Absendinasluar;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class OfficeTripAtt extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Absen Dinas Luar')]
    public function render()
    {
        $belumApprove = Absendinasluar::whereNull('approval')->with('absenkaryawandetail')->get();

        return view('livewire.new-admin.report.office-trip-att', compact('belumApprove'));
    }
}
