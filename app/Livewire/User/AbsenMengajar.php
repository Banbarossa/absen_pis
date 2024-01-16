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
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
    }

    public function render()
    {

        // $user = Auth::user();
        // $hari_ini = Carbon::now()->toDateString();

        // $absens = Absensekolah::with('complainmengajar', 'rombel', 'mapel')
        //     ->where('user_id', $user->id)
        //     ->where('tanggal', '>=', now()->startOfMonth()) // Awal bulan
        //     ->where('tanggal', '<=', $hari_ini)
        //     ->when($hari_ini == now()->toDateString(), function ($query) {
        //         $query->where('mulai_kbm', '<=', now()->format('H:i:s'));
        //     })
        //     ->orderBy('tanggal', 'desc')
        //     ->paginate(15);

        $user = Auth::user();
        $hari_ini = Carbon::now()->toDateString();
        $absens = Absensekolah::with('complainmengajar', 'rombel', 'mapel')->where('user_id', $user->id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->when('tanggal' == $hari_ini, function ($query) {
                $query->where('mulai_kbm', '<=', Carbon::now()->format('H:i:s'));
            })
            ->orderBy('tanggal', 'desc')
            ->paginate('15');

        return view('livewire.user.absen-mengajar', [
            'absens' => $absens,
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
