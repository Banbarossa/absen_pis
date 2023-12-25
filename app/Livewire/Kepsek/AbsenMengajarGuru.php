<?php

namespace App\Livewire\Kepsek;

use App\Models\Absenalternatif;
use App\Models\Absensekolah;
use App\Models\Sekolah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AbsenMengajarGuru extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $startDate, $endDate;
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $change_to, $reason, $absensekolah_id;
    public $alasan;

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(7)->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }

    public function render()
    {
        $user = Auth::user();
        $sekolah = Sekolah::where('user_id', $user->id)->first();

        $absens = Absensekolah::with('rombel', 'mapel', 'user')
            ->where('sekolah_id', $sekolah->id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->orderBy('tanggal', 'desc')
            ->paginate('15');

        return view('livewire.kepsek.absen-mengajar-guru', ['absens' => $absens])->layout('layouts.app');
    }

    public function absenAlternatif($id)
    {
        $absen = Absenalternatif::find($id);
        $this->alasan = $absen->alasan;
    }

    public function clear()
    {

    }
}
