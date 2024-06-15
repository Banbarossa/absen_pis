<?php

namespace App\Livewire\NewAdmin\Sekolah;

use App\Models\Absensekolah;
use App\Models\Complainmengajar;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ComplainAbsen extends Component
{
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Complain Absen Mengajar')]

    public function render()
    {
        $nonApproval = Complainmengajar::whereNull('status')->latest()->with(['absensekolah.user', 'absensekolah.mapel', 'absensekolah.rombel'])->get();
        $approval = Complainmengajar::whereStatus(true)->latest()->take(20)->with(['absensekolah.user', 'absensekolah.mapel', 'absensekolah.rombel'])->get();
        $denied = Complainmengajar::whereStatus(false)->latest()->take(20)->with(['absensekolah.user', 'absensekolah.mapel', 'absensekolah.rombel'])->get();

        return view('livewire.new-admin.sekolah.complain-absen', compact('nonApproval', 'approval', 'denied'));
    }

    public function denie($id)
    {
        $complain = Complainmengajar::find($id);
        $complain->status = false;
        $complain->save();

        $this->alert('success', 'Complain Berhasil ditolak');

    }
    public function approve($id)
    {
        $complain = Complainmengajar::findOrFail($id);
        $absen = Absensekolah::findOrFail($complain->absensekolah_id);

        DB::beginTransaction();

        try {
            $complain->status = true;
            $complain->save();

            $absen->kehadiran = true;
            $absen->kehadiran = $complain->change_to;
            if ($complain->change_to == 'hadir') {
                $absen->waktu_absen = $absen->mulai_kbm;
            }
            $absen->save();

            DB::commit();
            $this->alert('success', 'Complain Berhasil diterima');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->alert('error', 'Complain gagal diapprove');
        }

    }
}
