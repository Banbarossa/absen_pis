<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class RekapKehadiranMusyrifHalaqah
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($data): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->BarChart()
            ->setTitle($data['title'])
            ->setSubtitle($data['subTitle'])
            ->setColors($data['color'])
            ->addData('Hadir', $data['datasets']['Hadir'])
            ->addData('Izin Dinas', $data['datasets']['Izin Dinas'])
            ->addData('Izin Pribadi', $data['datasets']['Izin Pribadi'])
            ->addData('Sakit', $data['datasets']['Sakit'])
            ->addData('Alpa', $data['datasets']['Alpa'])
            ->setXAxis($data['labels']);
    }
}
