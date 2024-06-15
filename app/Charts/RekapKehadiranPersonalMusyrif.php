<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class RekapKehadiranPersonalMusyrif
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $data): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        return $this->chart->areaChart()
            ->setTitle($data['title'])
            ->setSubtitle($data['setSubtitle'])
            ->addData('Kehadiran', $data['dataset'])
            ->setXAxis($data['labels']);
    }
}
