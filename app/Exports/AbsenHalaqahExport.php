<?php

namespace App\Exports;

use App\Models\Absenhalaqah;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsenHalaqahExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Absenhalaqah::query()
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->join('users', 'absenhalaqahs.user_id', '=', 'users.id')
            ->join('jadwal_halaqahs', 'absenhalaqahs.jadwal_halaqah_id', '=', 'jadwal_halaqahs.id')
            ->select('absenhalaqahs.tanggal', 'users.name', 'jadwal_halaqahs.nama_sesi', 'absenhalaqahs.waktu_absen', 'absenhalaqahs.kehadiran')
        ;

        $model = Absenhalaqah::with('user', 'jadwalhalaqah')
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->leftJoin('users', 'absenhalaqahs.user_id', '=', 'users.id');
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama',
            'Sesi',
            'Waktu Absen',
            'Status',
        ];

    }
}
