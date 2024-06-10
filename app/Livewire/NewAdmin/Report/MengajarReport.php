<?php

namespace App\Livewire\NewAdmin\Report;

use App\Exports\RekapAbsenSekolah;
use App\Models\Absensekolah;
use App\Models\Sekolah;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class MengajarReport extends Component
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

        $sekolahs = Sekolah::all();

        $absensekolah = $this->getAbsenSekolah();

        return view('livewire.new-admin.report.mengajar-report', compact('absensekolah', 'sekolahs'));
    }

    public function getAbsenSekolah()
    {
        $absensekolah = Absensekolah::whereBetween('absensekolahs.tanggal', [$this->startDate, $this->endDate])
            ->when($this->sekolah_id, function ($query) {
                $query->where('absensekolahs.sekolah_id', $this->sekolah_id);
            })
            ->join('users', 'users.id', '=', 'absensekolahs.user_id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                \DB::raw('SUM(CASE WHEN absensekolahs.kehadiran = "hadir" THEN absensekolahs.jumlah_jam ELSE 0 END) as jam_hadir'),
                \DB::raw('SUM(CASE WHEN absensekolahs.kehadiran = "izin dinas" THEN absensekolahs.jumlah_jam ELSE 0 END) as jam_izindinas'),
                \DB::raw('SUM(CASE WHEN absensekolahs.kehadiran = "izin pribadi" THEN absensekolahs.jumlah_jam ELSE 0 END) as jam_izinpribadi'),
                \DB::raw('SUM(CASE WHEN absensekolahs.kehadiran = "sakit" THEN absensekolahs.jumlah_jam ELSE 0 END) as jam_sakit'),
                \DB::raw('SUM(CASE WHEN absensekolahs.kehadiran = "alpa" THEN absensekolahs.jumlah_jam ELSE 0 END) as jam_alpa'),

                \DB::raw('count(DISTINCT CASE WHEN absensekolahs.kehadiran="hadir" THEN absensekolahs.tanggal ELSE null END) as jumlah_hari_hadir'),

            )
            ->groupBy('users.id', 'users.name')
            ->orderBy('users.name')
            ->get();

        return $absensekolah;

    }

    public function unduhExcel()
    {
        $models = $this->getAbsenSekolah();
        $filename = 'Rekap Absen Mengajar ' . date('Y-m-d H_i_s') . '.xls';
        $periode = $this->startDate . ' s/d ' . $this->endDate;

        $jenjang = ' Semua Jenjang';
        if ($this->sekolah_id) {
            $jenjang = Sekolah::findOrFail($this->sekolah_id)->jenjang;
        }
        return Excel::download(new RekapAbsenSekolah($models, $periode, $jenjang), $filename);

    }
}
