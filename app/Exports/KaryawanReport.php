<?php

namespace App\Exports;

use App\Models\Absenkaryawan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanReport implements FromQuery, WithHeadings, ShouldAutoSize
{

    public $startDate;
    public $endDate;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {

        return Absenkaryawan::query()
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->join('users', 'absenkaryawans.user_id', '=', 'users.id')
            ->join('jamkaryawans', 'absenkaryawans.jamkaryawan_id', '=', 'jamkaryawans.id')
            ->select('users.name', 'absenkaryawans.tanggal', 'jamkaryawans.nama_jam_kerja', 'absenkaryawans.jam_masuk', 'absenkaryawans.jam_pulang', 'absenkaryawans.scan_masuk', 'absenkaryawans.scan_pulang', 'absenkaryawans.masuk_in_location', 'absenkaryawans.pulang_in_location')
        ;
    }

    public function headings(): array
    {
        return [
            'Nama',
            'tanggal',
            'Jam Kerja',
            'Jam Masuk',
            'Jam Pulang',
            'Scan Masuk',
            'Scan Pulang',
            'Lokasi Masuk',
            'Lokasi Pulang',
        ];
    }
}
