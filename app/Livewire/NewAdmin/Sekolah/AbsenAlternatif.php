<?php

namespace App\Livewire\NewAdmin\Sekolah;

use App\Models\Absenalternatif as ModelsAbsenalternatif;
use App\Models\Absensekolah;
use App\Models\Rombel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AbsenAlternatif extends Component
{

    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Absen Alternative')]
    public function render()
    {
        $nonApproval = ModelsAbsenalternatif::whereNull('approved')
            ->with('user', 'rombel')
            ->latest()
            ->get();

        $approval = ModelsAbsenalternatif::whereApproved(true)
            ->with('user', 'rombel')
            ->latest()
            ->take(20)
            ->get();
        $denied = ModelsAbsenalternatif::whereApproved(false)
            ->with('user', 'rombel')
            ->latest()
            ->take(20)
            ->get();

        return view('livewire.new-admin.sekolah.absen-alternatif', compact('nonApproval', 'approval', 'denied'));
    }

    public function destroy($id)
    {
        $absen = ModelsAbsenalternatif::findOrFail($id);
        $fileName = $absen->image;

        $folderPath = "public/images/";
        $filePath = $folderPath . $fileName;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $absen->delete();

        $this->alert('success', 'Absen Berhasil dihapus');
    }

    public function denie($id)
    {
        $absen = ModelsAbsenalternatif::findOrFail($id);
        $absen->approved = false;
        $absen->approved_by = Auth::user()->id;
        $absen->save();
        $this->alert('success', 'Data Berhasil ditolak');
    }

    public function approve($id)
    {
        $absen = ModelsAbsenalternatif::findOrFail($id);
        $sekolah_id = Rombel::where('id', $absen->rombel_id)->first()->sekolah_id;

        DB::beginTransaction();
        try {
            $absen->approved = true;
            $absen->approved_by = Auth::user()->id;
            $absen->save();

            Absensekolah::create([
                'user_id' => $absen->user_id,
                'tanggal' => $absen->tanggal,
                'rombel_id' => $absen->rombel_id,
                'sekolah_id' => $absen->sekolah_id,
                'waktu_absen' => Carbon::parse($absen->created_at)->format('H:I:s'),
                'kehadiran' => 'hadir',
                'jumlah_jam' => $absen->jumlah_jam,
                'image' => $absen->image,
                'absenalternatif_id' => $absen->id,
            ]);

            DB::commit();

            $this->alert('success', 'Absen Alternatif berhasil disetujui');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', 'Absen Alternatif gagal disetujui');
        }
    }

}
