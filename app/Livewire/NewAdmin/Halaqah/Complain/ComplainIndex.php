<?php

namespace App\Livewire\NewAdmin\Halaqah\Complain;

use App\Models\Absenhalaqah;
use App\Models\Complainhalaqah;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ComplainIndex extends Component
{
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Complain Absen Halaqah')]
    public function render()
    {
        $models = Complainhalaqah::whereStatus(null)->latest()->with(['absenhalaqah.user', 'absenhalaqah.jadwalhalaqah'])->get();
        return view('livewire.new-admin.halaqah.complain.complain-index', compact('models'));
    }

    public function denie($id)
    {
        $complain = Complainhalaqah::find($id);
        $complain->status = false;
        $complain->save();
        $this->alert('success', 'Permohonan Complain Absen berhasil ditolak');
        $this->dispatch('complainDenied');
    }

    public function approve($id)
    {

        DB::beginTransaction();
        try {
            $complain = Complainhalaqah::find($id);
            $complain->status = true;
            $complain->save();

            $absen = Absenhalaqah::find($complain->absenhalaqah_id);
            $absen->kehadiran = $complain->change_to;
            $absen->save();

            DB::commit();
            $this->alert('success', 'Data berhasil disimpan');

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', 'Data Gagal disimpan');
            throw $e;
        }

        $this->dispatch('complainApproved');

    }
}
