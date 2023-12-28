<?php

namespace App\Exports;

use App\Models\Absensekolah;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Laporanpersekolah implements FromQuery, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
    public $sekolah_id, $startDate, $endDate;

    public function __construct($sekolah_id, $startDate, $endDate)
    {
        $this->sekolah_id = $sekolah_id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Absensekolah::query()
            ->where('absensekolahs.sekolah_id', $this->sekolah_id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
        // ->where('tanggal', '>=', $this->startDate)
        // ->where('tanggal', '<=', $this->endDate)
            ->leftJoin('users', 'absensekolahs.user_id', '=', 'users.id')
            ->leftJoin('rombels', 'absensekolahs.rombel_id', '=', 'rombels.id')
            ->leftJoin('mapels', 'absensekolahs.mapel_id', '=', 'mapels.id')
            ->select('users.name', 'tanggal', 'jam_ke', 'mulai_kbm', 'akhir_kbm', 'rombels.nama_rombel', 'mapels.mata_pelajaran', 'waktu_absen', 'keterlambatan', 'kehadiran', 'jumlah_jam');

    }

    public function headings(): array
    {
        return [
            'nama', 'tanggal', 'jam Ke', 'Mulai KBM', 'Akhir KBM', 'Rombel', 'Mata Pelajaran', 'Waktu Absen', 'Keterlambatan', 'kehadiran', 'Jumlah Jam',
        ];
    }
}
