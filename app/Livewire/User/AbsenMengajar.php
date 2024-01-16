<?php

namespace App\Livewire\User;

use App\Models\Absensekolah;
use App\Models\Complainmengajar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AbsenMengajar extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $startDate, $endDate;
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $change_to, $reason, $absensekolah_id;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->subDay(1)->toDateString();
    }

    public function render()
    {

        $today = Carbon::now()->toDateString();

        $user = Auth::user();
        $absens = Absensekolah::with('complainmengajar', 'rombel', 'mapel')->where('user_id', $user->id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->orderBy('tanggal', 'desc')
            ->paginate('15');

        $absen_hari_ini = Absensekolah::with('complainmengajar', 'rombel', 'mapel')->where('user_id', $user->id)
            ->where('tanggal', '=', $today)
            ->where('mulai_kbm', '<=', Carbon::now()->format('H:i:s'))
            ->orderBy('jam_ke', 'desc')
            ->paginate('15');

        return view('livewire.user.absen-mengajar', [
            'absens' => $absens,
            'absen_hari_ini' => $absen_hari_ini,
        ])->layout('layouts.app');
    }

    public function complain($id)
    {
        $this->absensekolah_id = $id;
    }

    public function storeComplain()
    {
        $this->validate([
            'change_to' => 'required',
            'reason' => 'required',
        ]);

        Complainmengajar::create([
            'absensekolah_id' => $this->absensekolah_id,
            'change_to' => $this->change_to,
            'reason' => $this->reason,

        ]);
        $this->clear();
        $this->alert('success', 'Complain Berhasil diajaukan');
        $this->dispatch('close-modal');
    }

    public function clear()
    {
        $this->absensekolah_id = '';
        $this->change_to = '';
        $this->reason = '';
    }
}
