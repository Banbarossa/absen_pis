<?php

namespace App\Livewire\NewAdmin\Report;

use App\Exports\RekapLaporanAbsenPegawai;
use App\Models\Absenkaryawan;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiReport extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('Rekap Absen')]

    public $startDate;
    public $endDate;
    public $jumlahharikerja;
    public $jumlahMinggu;
    public $jumlahharilibur = 0;

    public $sekolah_id;

    public function mount()
    {
        $startDate = Carbon::now()->subMonths(1)->startOfMonth()->addDays(26);
        $endDate = Carbon::now()->startOfMonth()->addDays(25);
        $today = Carbon::now();
        if ($today < $endDate) {
            $this->endDate = $today->toDateString();
        } else {

            $this->endDate = $endDate->toDateString();
        }

        $this->startDate = $startDate->toDateString();
    }

    public function updatedStartDate($value)
    {

        $this->dispatch('startDateUpdated', startDate: $this->startDate);
    }

    public function updatedEndDate($value)
    {
        $selectedDate = Carbon::parse($value);
        $today = Carbon::now()->startOfDay();

        if ($selectedDate->greaterThan($today)) {
            $this->endDate = Carbon::now()->toDateString();
        }

        $this->dispatch('endDateUpdated', endDate: $this->endDate);
    }

    public function hitungMinggu()
    {

        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);
        $jumlahMinggu = 0;
        while ($startDate->lte($endDate)) {
            if ($startDate->isSunday()) {
                $jumlahMinggu++;
            }
            $startDate->addDay();
        }
        return $jumlahMinggu;

    }

    public function selisihhari()
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);

        return $endDate->diffInDays($startDate);
    }

    public function increment()
    {
        $this->jumlahharilibur++;
    }

    public function decrement()
    {
        if ($this->jumlahharilibur > 0) {
            $this->jumlahharilibur--;
        }
    }

    public function newData()
    {

        $pegawais = Absenkaryawan::whereBetween('absenkaryawans.created_at', [$this->startDate, $this->endDate])
            ->with(['user', 'absenkaryawandetails' => function ($query) {
                $query->whereIn('type', ['masuk_1', 'masuk_2', 'pulang']);
            }, 'absenkaryawandetails.absendinasluar' => function ($query) {
                $query->where('approval', true);
            }])
            ->get()
            ->map(function ($absenkaryawan) {
                $masuk1Details = $absenkaryawan->absenkaryawandetails->where('type', 'masuk_1');
                $masuk2Details = $absenkaryawan->absenkaryawandetails->where('type', 'masuk_2');
                $pulangDetails = $absenkaryawan->absenkaryawandetails->where('type', 'pulang');

                $jumlahScanMasuk1 = $masuk1Details->count();
                $terlambatMasuk1 = $masuk1Details->sum('selisih_waktu');

                $jumlahScanMasuk2 = $masuk2Details->count();
                $terlambatMasuk2 = $masuk2Details->sum('selisih_waktu');

                $jumlahScanPulang = $pulangDetails->count();

                return [
                    'user_id' => $absenkaryawan->user->id,
                    'user_name' => $absenkaryawan->user->name,
                    'total_hadir' => 1, // Karena ini dihitung per absenkaryawan
                    'jumlah_scan_masuk1' => $jumlahScanMasuk1,
                    'terlambat_masuk1' => $terlambatMasuk1,
                    'jumlah_scan_masuk2' => $jumlahScanMasuk2,
                    'terlambat_masuk2' => $terlambatMasuk2,
                    'jumlah_scan_pulang' => $jumlahScanPulang,
                ];
            })
            ->groupBy('user_id')
            ->map(function ($group) {
                return $group->reduce(function ($carry, $item) {
                    if (is_null($carry)) {
                        return $item;
                    }
                    $carry['total_hadir'] += $item['total_hadir'];
                    $carry['jumlah_scan_masuk1'] += $item['jumlah_scan_masuk1'];
                    $carry['terlambat_masuk1'] += $item['terlambat_masuk1'];
                    $carry['jumlah_scan_masuk2'] += $item['jumlah_scan_masuk2'];
                    $carry['terlambat_masuk2'] += $item['terlambat_masuk2'];
                    $carry['jumlah_scan_pulang'] += $item['jumlah_scan_pulang'];
                    return $carry;
                });
            })
            ->values()
            ->sortBy('user_name')
            ->values();

        return $pegawais;
    }

    public function render()
    {

        $this->jumlahMinggu = $this->hitungMinggu();
        $this->jumlahharikerja = $this->selisihhari();

        $pegawais = $this->newData();

        return view('livewire.new-admin.report.pegawai-report', compact('pegawais'));
    }

    public function unduhExcel()
    {

        $models = $this->newData();
        $filename = 'Rekap Laporan Pegawai ' . date('Y m d H:I:s') . '.xls';
        $periode = $this->startDate . ' s/d ' . $this->endDate;

        return Excel::download(new RekapLaporanAbsenPegawai($models, $periode), $filename);
    }

    // public function getLaporanPegawai()
    // {

    //     $pegawais = Absenkaryawan::whereBetween('absenkaryawans.created_at', [$this->startDate, $this->endDate])
    //         ->join('users', 'users.id', '=', 'absenkaryawans.user_id')
    //         ->leftJoin('absenkaryawandetails as masuk1', function ($join) {
    //             $join->on('absenkaryawans.id', '=', 'masuk1.absenkaryawan_id')
    //                 ->where('masuk1.type', 'masuk_1');
    //         })
    //         ->leftJoin('absenkaryawandetails as masuk2', function ($join) {
    //             $join->on('absenkaryawans.id', '=', 'masuk2.absenkaryawan_id')
    //                 ->where('masuk2.type', 'masuk_2');
    //         })
    //         ->leftJoin('absenkaryawandetails as pulang', function ($join) {
    //             $join->on('absenkaryawans.id', '=', 'pulang.absenkaryawan_id')
    //                 ->where('pulang.type', 'pulang');
    //         })
    //         ->select(
    //             'users.id as user_id',
    //             'users.name as user_name',
    //             'absenkaryawans.user_id',
    //             \DB::raw('count(absenkaryawans.id) as total_hadir'),
    //             \DB::raw('count(masuk1.id) as jumlah_scan_masuk1'),
    //             \DB::raw('SUM(CASE WHEN masuk1.type = "masuk_1" THEN masuk1.selisih_waktu ELSE 0 END) as terlambat_masuk1'),
    //             \DB::raw('count(masuk2.id) as jumlah_scan_masuk2'),
    //             \DB::raw('SUM(CASE WHEN masuk2.type = "masuk_2" THEN masuk2.selisih_waktu ELSE 0 END) as terlambat_masuk2'),
    //             \DB::raw('count(pulang.id) as jumlah_scan_pulang'),
    //             // \DB::raw('(SELECT count(*) FROM absenkaryawandetails ad WHERE ad.absenkaryawan_id = absenkaryawans.id AND ad.type = "masuk_1" AND (NOT EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id) OR EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id AND dl.approval = true))) as jumlah_scan_masuk1'),
    //             // \DB::raw('(SELECT SUM(ad.selisih_waktu) FROM absenkaryawandetails ad WHERE ad.absenkaryawan_id = absenkaryawans.id AND ad.type = "masuk_1" AND (NOT EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id) OR EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id AND dl.approval = true))) as terlambat_masuk1'),
    //             // \DB::raw('(SELECT count(*) FROM absenkaryawandetails ad WHERE ad.absenkaryawan_id = absenkaryawans.id AND ad.type = "masuk_2" AND (NOT EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id) OR EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id AND dl.approval = true))) as jumlah_scan_masuk2'),
    //             // \DB::raw('(SELECT SUM(ad.selisih_waktu) FROM absenkaryawandetails ad WHERE ad.absenkaryawan_id = absenkaryawans.id AND ad.type = "masuk_2" AND (NOT EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id) OR EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id AND dl.approval = true))) as terlambat_masuk2'),
    //             // \DB::raw('(SELECT count(*) FROM absenkaryawandetails ad WHERE ad.absenkaryawan_id = absenkaryawans.id AND ad.type = "pulang" AND (NOT EXISTS (SELECT 1 FROM absendinasluars dl WHERE dl.absenkaryawan_id = absenkaryawans.id) OR EXISTS (SELECT 1 FROM absendinasluar dl WHERE dl.absenkaryawan_id = absenkaryawans.id AND dl.approval = true))) as jumlah_scan_pulang')
    //         )
    //         ->groupBy('users.name', 'absenkaryawans.user_id')
    //         ->orderBy('users.name')
    //         ->get();

    //     return $pegawais;

    // }

}
