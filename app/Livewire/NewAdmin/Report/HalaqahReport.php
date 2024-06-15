<?php

namespace App\Livewire\NewAdmin\Report;

use App\Exports\RekapLaporanAbsenHalaqah;
use App\Models\Absenhalaqah;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class HalaqahReport extends Component
{
    public $startDate;
    public $endDate;

    public $sekolah_id;

    public function mount($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    #[On('startDateUpdated')]
    public function startDateUpdated($startDate)
    {
        $this->startDate = $startDate;
    }

    #[On('endDateUpdated')]
    public function endDateUpdated($endDate)
    {
        $this->endDate = $endDate;
    }

    public function render()
    {
        $absenHalaqah = $this->getDataAbsenHalaqah();

        return view('livewire.new-admin.report.halaqah-report', compact('absenHalaqah'));
    }

    public function getDataAbsenHalaqah()
    {

        $absenHalaqah = Absenhalaqah::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($absen) {
                $user = $absen->first()->user;

                $jumlah_hadir = $absen->where('kehadiran', 'hadir')->count();
                $jumlah_izin_dinas = $absen->where('kehadiran', 'izin dinas')->count();
                $jumlah_izin_pribadi = $absen->where('kehadiran', 'izin pribadi')->count();
                $jumlah_sakit = $absen->where('kehadiran', 'sakit')->count();
                $jumlah_alpa = $absen->where('kehadiran', 'alpa')->count();

                return [
                    'user_id' => $user->id,
                    'nama' => $user->name,
                    'hadir' => $jumlah_hadir,
                    'izin_dinas' => $jumlah_izin_dinas,
                    'izin_pribadi' => $jumlah_izin_pribadi,
                    'sakit' => $jumlah_sakit,
                    'alpa' => $jumlah_alpa,
                ];
            })
            ->sortBy(function ($item) {
                return $item['nama'];
            })
            ->values()
        ;

        return $absenHalaqah;
    }

    public function unduhExcel()
    {
        $models = $this->getDataAbsenHalaqah();
        $periode = $this->startDate . ' s/d ' . $this->endDate;
        $filename = 'Rekap laporan Halaqah' . date('Y m d H:I:s') . '.xls';
        return Excel::download(new RekapLaporanAbsenHalaqah($models, $periode), $filename);
    }

}
