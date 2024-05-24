<?php

namespace App\Livewire\User;

use App\Charts\UserAbsenChart;
use App\Models\Absenhalaqah;
use App\Models\JadwalHalaqah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{

    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $startDate, $endDate;
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $change_to, $reason, $absenhalaqah_id;

    #[Layout('layouts.app')]
    #[Title('Dashboard')]

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
    }

    public function render(UserAbsenChart $chart)
    {
        $user = Auth::user();
        $data = Absenhalaqah::where('user_id', $user->id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->orderBy('tanggal', 'desc');

        $dataCount = $data->get();

        // Initialize counts
        $countHalaqah = [
            'hadir' => 0,
            'sakit' => 0,
            'izin_pribadi' => 0,
            'izin_dinas' => 0,
            'alpa' => 0,
        ];

        // Calculate counts
        foreach ($dataCount as $item) {
            switch ($item->kehadiran) {
                case 'hadir':
                    $countHalaqah['hadir']++;
                    break;
                case 'sakit':
                    $countHalaqah['sakit']++;
                    break;
                case 'izin pribadi':
                    $countHalaqah['izin_pribadi']++;
                    break;
                case 'izin dinas':
                    $countHalaqah['izin_dinas']++;
                    break;
                case 'alpa':
                    $countHalaqah['alpa']++;
                    break;
            }
        }

        $jadwalHalaqah = JadwalHalaqah::all();
        $absens = $data->paginate(15);

        return view('livewire.user.dashboard', [
            'user' => Auth::user(),
            'absens' => $absens,
            'countHalaqah' => $countHalaqah,
            // 'chart' => $chart->build($user->id, $this->startDate, $this->endDate),
            'jadwalHalaqah' => $jadwalHalaqah,
        ]);
    }

}
