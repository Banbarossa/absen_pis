<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenkaryawan;
use App\Models\Absenkaryawandetail;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class WidgetCountAbsenHarian extends Component
{
    public function render()
    {

        $today = Carbon::now()->toDateString();
        $pegawai = User::whereStatus(true)->where('is_karyawan', true)->count();
        $jumlahAbsen = Absenkaryawan::whereTanggal($today)->count();

        $absenDetails = Absenkaryawandetail::whereHas('absenkaryawan', function ($query) use ($today) {
            $query->where('tanggal', $today);
        })->get();

        $masuk_1 = $absenDetails->where('type', 'masuk_1')->count();
        $masuk_2 = $absenDetails->where('type', 'masuk_2')->count();
        $pulang = $absenDetails->where('type', 'pulang')->count();

        $persentaseMasuk_1 = ($pegawai > 0) ? round(($masuk_1 / $pegawai) * 100) : 0;
        $persentaseMasuk_2 = ($pegawai > 0) ? round(($masuk_2 / $pegawai) * 100) : 0;
        $persentasePulang = ($pegawai > 0) ? round(($pulang / $pegawai) * 100) : 0;

        return view('livewire.user.dashboard.widget-count-absen-harian', [
            'total_karyawan' => $pegawai,
            'jumlah_absen' => $jumlahAbsen,
            // 'masuk_1' => $masuk_1,
            // 'masuk_2' => $masuk_2,
            // 'pulang' => $pulang,
            'persentase_masuk_1' => $persentaseMasuk_1,
            'persentase_masuk_2' => $persentaseMasuk_2,
            'persentase_pulang' => $persentasePulang,
        ]);
    }
}
