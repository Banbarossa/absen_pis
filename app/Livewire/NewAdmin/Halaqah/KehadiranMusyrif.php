<?php

namespace App\Livewire\NewAdmin\Halaqah;

use App\Charts\RekapKehadiranMusyrifHalaqah;
use App\Exports\RekapLaporanAbsenHalaqah;
use App\Models\Absenhalaqah;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class KehadiranMusyrif extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Kehadiran Musyrif')]

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->subMonths(1)->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }
    public function render(RekapKehadiranMusyrifHalaqah $chart)
    {
        $summaries = $this->getData();

        $labels = $summaries->pluck('nama')->toArray();
        $dataHadir = $summaries->pluck('hadir')->toArray();
        $dataIzinDinas = $summaries->pluck('izin_dinas')->toArray();
        $dataIzinPribadi = $summaries->pluck('izin_pribadi')->toArray();
        $dataSakit = $summaries->pluck('sakit')->toArray();
        $dataAlpa = $summaries->pluck('alpa')->toArray();

        $data = [
            'title' => 'Kehadiran Musyrif',
            'subTitle' => 'Periode ' . $this->startDate . ' s/d ' . $this->endDate,
            'labels' => $labels,
            'color' => ['#4CAF50', '#2196F3', '#FFC107', '#9C27B0', '#FF5722'],
            'datasets' => [
                'Hadir' => $dataHadir,
                'Izin Dinas' => $dataIzinDinas,
                'Izin Pribadi' => $dataIzinPribadi,
                'Sakit' => $dataSakit,
                'Alpa' => $dataAlpa,
            ],
        ];

        $chart = $chart->build($data);

        $this->dispatch('renderChart');
        return view('livewire.new-admin.halaqah.kehadiran-musyrif', compact('summaries', 'chart'));
    }

    public function getData()
    {
        $summaries = Absenhalaqah::whereBetween('tanggal', [$this->startDate, $this->endDate])->with('user')
            ->get()
            ->groupBy('user_id')
            ->map(function ($absenGroup) {
                $user = $absenGroup->first()->user;
                $jumlahtotal = $absenGroup->wherein('kehadiran', ['hadir', 'izin dinas', 'izin pribadi', 'sakit', 'alpa'])->count();
                $jumlahhadir = $absenGroup->where('kehadiran', 'hadir')->count();
                $jumlahizindinas = $absenGroup->where('kehadiran', 'izin dinas')->count();
                $jumlahizinpribadi = $absenGroup->where('kehadiran', 'izin pribadi')->count();
                $jumlahizinsakit = $absenGroup->where('kehadiran', 'sakit')->count();
                $jumlahizinalpa = $absenGroup->where('kehadiran', 'alpa')->count();

                return [
                    'user_id' => $user->id,
                    'nama' => $user->name,
                    'total' => $jumlahtotal,
                    'hadir' => $jumlahhadir,
                    'izin_dinas' => $jumlahizindinas,
                    'izin_pribadi' => $jumlahizinpribadi,
                    'sakit' => $jumlahizinsakit,
                    'alpa' => $jumlahizinalpa,
                ];

            })
            ->values()
            ->sortBy('nama')
            ->values();
        return $summaries;
    }

    public function dataChart()
    {
        $this->getData();
    }

    public function unduhExcel()
    {
        $models = $this->getData();
        $periode = $this->startDate . ' s/d ' . $this->endDate;
        $filename = 'Rekap laporan Halaqah' . date('Y m d H:I:s') . '.xls';
        return Excel::download(new RekapLaporanAbsenHalaqah($models, $periode), $filename);
    }
}
