<?php

namespace App\Livewire\Kepsek;

use App\Models\Absensekolah;
use App\Models\Sekolah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RekapMengajar extends Component
{

    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $startDate, $endDate;
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $change_to, $reason, $absensekolah_id;
    public $user_id, $nama_guru;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }

    public function render()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();

        $rekapData = Absensekolah::with('user', 'rombel')
            ->where('sekolah_id', $sekolah->id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->get();
        $detail = $rekapData;
        if ($this->user_id) {
            $detail = $rekapData->where('user_id', $this->user_id);
        }

        $groupedRekapData = $rekapData->groupBy('user_id');

        $summaryData = $groupedRekapData->map(function ($group) {
            $totalHadir = $group->where('kehadiran', 'hadir')->sum('jumlah_jam');
            $totalSakit = $group->where('kehadiran', 'sakit')->sum('jumlah_jam');
            $totalIzin = $group->where('kehadiran', 'izin')->sum('jumlah_jam');
            $totalIzinDinas = $group->where('kehadiran', 'izin dinas')->sum('jumlah_jam');
            $totalIzinPribadi = $group->where('kehadiran', 'izin pribadi')->sum('jumlah_jam');
            $totalAlpa = $group->where('kehadiran', 'alpa')->sum('jumlah_jam');
            $totalKeterlambatan = $group->sum('keterlambatan');

            return [
                'user_id' => $group->first()->user_id,
                'user_name' => $group->first()->user->name,
                'total_hadir' => $totalHadir,
                'totalSakit' => $totalSakit,
                'total_izin' => $totalIzin,
                'totalIzinDinas' => $totalIzinDinas,
                'totalIzinPribadi' => $totalIzinPribadi,
                'total_alpa' => $totalAlpa,
                'total_keterlambatan' => $totalKeterlambatan,
            ];
        });

        $sortedSummaryData = $summaryData->sortBy('user_name');

        $sortedSummaryData = $sortedSummaryData->values()->all();

        //Count All
        $counts = [
            'hadir' => 0,
            'izin dinas' => 0,
            'izin pribadi' => 0,
            'sakit' => 0,
            'alpa' => 0,
        ];

        // Calculate counts
        foreach ($rekapData as $data) {
            switch ($data->kehadiran) {
                case 'hadir':
                    $counts['hadir']++;
                    break;
                case 'izin dinas':
                    $counts['izin dinas']++;
                    break;
                case 'izin pribadi':
                    $counts['izin pribadi']++;
                    break;
                case 'sakit':
                    $counts['sakit']++;
                    break;
                case 'alpa':
                    $counts['alpa']++;
                    break;
            }
        }

        return view('livewire.kepsek.rekap-mengajar', [
            // 'chart' => $chart->build($sekolah->id, $this->startDate, $this->endDate),
            'sortedSummaryData' => $sortedSummaryData,
            'counts' => $counts,
            'sekolah' => $sekolah,
            'details' => $detail,
        ])->layout('layouts.app');
    }

    public function getDetailTeacher($id)
    {

        $this->user_id = $id;
        $this->nama_guru = User::find($id)->name;
    }
}
