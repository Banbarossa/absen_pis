<?php

namespace App\Livewire\NewAdmin\Report;

use App\Models\Absendinasluar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class OfficeTripAtt extends Component
{
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Absen Dinas Luar')]
    public function render()
    {
        $belumApprove = Absendinasluar::whereNull('approval')->with('absenkaryawandetail.absenkaryawan.user')->get();
        $approve = Absendinasluar::whereApproval(true)->with('absenkaryawandetail.absenkaryawan.user')->latest()->take(20)->get();
        $denied = Absendinasluar::whereApproval(false)->with('absenkaryawandetail.absenkaryawan.user')->latest()->take(20)->get();

        return view('livewire.new-admin.report.office-trip-att', compact('belumApprove', 'approve', 'denied'));
    }

    public function denie($id)
    {
        $absen = Absendinasluar::findOrFail($id);
        $absen->approval = false;
        $absen->save();
        $this->alert('success', 'Absen Dinas Luar tidak diterima');

    }
    public function approve($id)
    {
        $absen = Absendinasluar::findOrFail($id);
        $absen->approval = true;
        $absen->save();
        $this->alert('success', 'Absen Dinas Luar diterima');

    }
}
