<?php

namespace App\Livewire\NewAdmin\Report;

use App\Models\Absenhalaqah;
use Livewire\Attributes\On;
use Livewire\Component;

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
        $absenHalaqah = Absenhalaqah::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($absen) {
                $user_id = $absen->first()->user->id;
                $user = $absen->first()->user->name;

                $jumlah_hadir = $absen->where('kehadiran', 'hadir')->count();
                $jumlah_izin_dinas = $absen->where('kehadiran', 'izin dinas')->count();
                $jumlah_izin_pribadi = $absen->where('kehadiran', 'izin pribadi')->count();
                $jumlah_sakit = $absen->where('kehadiran', 'sakit')->count();
                $jumlah_alpa = $absen->where('kehadiran', 'alpa')->count();

                return [
                    'user_id' => $user_id,
                    'nama' => $user,
                    'hadir' => $jumlah_hadir,
                    'izin_dinas' => $jumlah_izin_dinas,
                    'izin_pribadi' => $jumlah_izin_pribadi,
                    'sakit' => $jumlah_sakit,
                    'alpa' => $jumlah_alpa,
                ];
            })
            ->sortBy(function ($nama) {
                return $nama;
            })
            ->values()
        ;

        return view('livewire.new-admin.report.halaqah-report', compact('absenHalaqah'));
    }
}
