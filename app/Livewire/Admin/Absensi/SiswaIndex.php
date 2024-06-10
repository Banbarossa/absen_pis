<?php

namespace App\Livewire\Admin\Absensi;

use App\Exports\RekapAbsenSiswa;
use App\Models\Absensiswa;
use App\Models\Rombel;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SiswaIndex extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Rekap Absensi Siswa')]

    public $kelas_id;

    public $startDate;
    public $endDate;

    public function mount()
    {

        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }

    public function render()
    {

        $rombel = Rombel::orderBy('tingkat_kelas', 'asc')->orderBy('nama_rombel', 'asc')->get();

        $absensiswa = $this->getAbsen();

        return view('livewire.admin.absensi.siswa-index', compact('rombel', 'absensiswa'));
    }

    public function getAbsen()
    {
        $absensiswa = Absensiswa::whereBetween(\DB::raw('DATE(absensiswas.created_at)'), [$this->startDate, $this->endDate])
            ->when($this->kelas_id, function ($query) {
                $query->where('absensiswas.rombel_id', $this->kelas_id);
            })
            ->join('rombels', 'rombels.id', '=', 'absensiswas.rombel_id')
            ->join('students', 'students.id', '=', 'absensiswas.student_id')
            ->select(
                'absensiswas.id as absen_id',
                'absensiswas.student_id as student_id',
                'rombels.nama_rombel',
                'students.name',
                \DB::raw("SUM(CASE WHEN absensiswas.status = 'h' THEN absensiswas.jumlah_jam ELSE 0 END) as total_jam_h"),
                \DB::raw("SUM(CASE WHEN absensiswas.status = 'i' THEN absensiswas.jumlah_jam ELSE 0 END) as total_jam_i"),
                \DB::raw("SUM(CASE WHEN absensiswas.status = 's' THEN absensiswas.jumlah_jam ELSE 0 END) as total_jam_s"),
                \DB::raw("SUM(CASE WHEN absensiswas.status = 'a' THEN absensiswas.jumlah_jam ELSE 0 END) as total_jam_a")
            )
            ->groupBy('absensiswas.id', 'rombels.nama_rombel', 'students.name')
            ->orderBy('rombels.nama_rombel')
            ->get();

        return $absensiswa;
    }

    public function unduhExcel()
    {
        $filename = 'Daftar Siswa ' . date('Y-m-d H_i_s') . '.xls';

        $models = $this->getAbsen();
        return Excel::download(new RekapAbsenSiswa($models), $filename);
    }
}
