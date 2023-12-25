<?php

namespace App\Charts;

use App\Models\Absensekolah;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AbsenMengajarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id, $startDate, $endDate): \ArielMejiaDev\LarapexCharts\PieChart
    {

        $absens = Absensekolah::where('sekolah_id', $id)
            ->where('tanggal', '>=', $startDate)
            ->where('tanggal', '<=', $endDate)
            ->get();

        return $this->chart->pieChart()
            ->setTitle('Chart Kehadiran Guru')
        // ->setSubtitle('Season 2021.')
            ->addData([
                $absens->where('kehadiran', 'hadir')->count(),
                $absens->where('kehadiran', 'sakit')->count(),
                $absens->where('kehadiran', 'izin')->count(),
                $absens->where('kehadiran', 'izin dinas')->count(),
                $absens->where('kehadiran', 'izin pribadi')->count(),
                $absens->where('kehadiran', 'alpa')->count(),
            ])
            ->setColors(['#5D9C59', '#1B6B93', '#F2EE9D', '#E7B10A', '#C70039', '#C70039'])
            ->setLabels(['hadir', 'sakit', 'izin', 'izin dinas', 'izin pribadi', 'alpa']);
    }
}
