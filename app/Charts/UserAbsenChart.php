<?php

namespace App\Charts;

use App\Models\Absenhalaqah;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UserAbsenChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id, $startDate, $endDate): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $absen = Absenhalaqah::where('user_id', $id)->where('tanggal', '>=', $startDate)->where('tanggal', '<=', $endDate)->get();
        return $this->chart->pieChart()
            ->setTitle('Absen Halaqah')
            ->addData([
                $absen->where('status_kehadiran', 'hadir')->count(),
                $absen->where('status_kehadiran', 'sakit')->count(),
                $absen->where('status_kehadiran', 'izin dinas')->count(),
                $absen->where('status_kehadiran', 'izin pribadi')->count(),
                $absen->where('status_kehadiran', 'alpa')->count(),

            ])
            ->setColors(['#5D9C59', '#1B6B93', '#F2EE9D', '#E7B10A', '#C70039'])
            ->setLabels(['Hadir', 'Sakit', 'Izin Dinas', 'Izin Pribadi', 'Alpa']);
    }
}
