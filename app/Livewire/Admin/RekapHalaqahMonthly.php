<?php

namespace App\Livewire\Admin;

use App\Models\Absenhalaqah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RekapHalaqahMonthly extends Component
{
    //perMusyrif
    public $absenPerMusyrif = [], $musyrifName;
    public $hadir, $sakit, $izin_dinas, $izin_pribadi, $alpa;

    public $startDate, $endDate;

    public function mount()
    {
        $now = Carbon::now();

        $this->startDate = $now->startOfMonth()->toDateString();

        $this->endDate = $now->endOfMonth()->toDateString();

    }

    public function render()
    {
        $rekap_data = DB::table('absenhalaqahs')
            ->select('user_id', 'users.name as user_name')
            ->leftJoin('users', 'users.id', '=', 'absenhalaqahs.user_id')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->groupBy('user_id', 'users.name')
            ->orderBy('users.name')
            ->selectRaw('
                COUNT(CASE WHEN kehadiran = "hadir" THEN 1 ELSE NULL END) as hadir,
                COUNT(CASE WHEN kehadiran = "sakit" THEN 1 ELSE NULL END) as sakit,
                COUNT(CASE WHEN kehadiran = "izin dinas" THEN 1 ELSE NULL END) as izin_dinas,
                COUNT(CASE WHEN kehadiran = "izin pribadi" THEN 1 ELSE NULL END) as izin_pribadi,
                COUNT(CASE WHEN kehadiran = "alpa" THEN 1 ELSE NULL END) as alpa
            ')
            ->get();

        $rekapTotal = DB::table('absenhalaqahs')
            ->selectRaw('
                COUNT(CASE WHEN kehadiran = "hadir" THEN 1 END) as total_hadir,
                COUNT(CASE WHEN kehadiran = "sakit" THEN 1 END) as total_sakit,
                COUNT(CASE WHEN kehadiran = "izin dinas" THEN 1 END) as total_izin_dinas,
                COUNT(CASE WHEN kehadiran = "izin pribadi" THEN 1 END) as total_izin_pribadi,
                COUNT(CASE WHEN kehadiran = "alpa" THEN 1 END) as total_alpa
            ')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->first();

        // dd($rekap_data);

        return view('livewire.admin.rekap-halaqah-monthly', [
            'rekap_data' => $rekap_data,
            'rekapTotal' => $rekapTotal,
        ])->layout('layouts.app');
    }

    public function detail($id)
    {

        $this->musyrifName = User::find($id)->name;
        $permusyrif = Absenhalaqah::with('jadwalhalaqah')
            ->where('user_id', $id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->get();

        $this->absenPerMusyrif = $permusyrif;

        $this->hadir = $permusyrif->where('kehadiran', 'hadir')->count();
        $this->sakit = $permusyrif->where('kehadiran', 'sakit')->count();
        $this->izin_dinas = $permusyrif->where('kehadiran', 'izin dinas')->count();
        $this->izin_pribadi = $permusyrif->where('kehadiran', 'izin pribadi')->count();
        $this->alpa = $permusyrif->where('kehadiran', 'alpa')->count();

    }
}
