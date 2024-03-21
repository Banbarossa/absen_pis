<?php

namespace App\Livewire\User;

use App\Models\Absenhalaqah;
use App\Models\Complainhalaqah;
use App\Models\JadwalHalaqah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Halaqah extends Component
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
    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->subDays(1)->toDateString();
    }

    public function render()
    {

        $user = Auth::user();
        $absens = Absenhalaqah::where('user_id', $user->id)
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->orderBy('tanggal', 'desc')
            ->paginate('15');

        $absen_hari_ini = Absenhalaqah::with('jadwalhalaqah')->where('user_id', $user->id)
            ->where('tanggal', Carbon::now()->toDateString())
            ->whereHas('jadwalhalaqah', function ($query) {
                $query->where('mulai_absen', '<', Carbon::now()->format('H:i:s'));
            })
            ->orderBy('tanggal', 'desc')
            ->paginate('15');

        $jadwalHalaqah = JadwalHalaqah::all();

        return view('livewire.user.halaqah', [
            'absens' => $absens,
            'absen_hari_ini' => $absen_hari_ini,
            'jadwalHalaqah' => $jadwalHalaqah,
        ]);

    }

    public function complain($id)
    {
        $this->absenhalaqah_id = $id;
    }

    public function storeComplain()
    {
        $this->validate([
            'change_to' => 'required',
            'reason' => 'required',
        ]);

        Complainhalaqah::create([
            'absenhalaqah_id' => $this->absenhalaqah_id,
            'change_to' => $this->change_to,
            'reason' => $this->reason,

        ]);
        $this->clear();
        $this->alert('success', 'Complain Berhasil diajaukan');
        $this->dispatch('close-modal');
    }

    public function clear()
    {
        $this->absenhalaqah_id = '';
        $this->change_to = '';
        $this->reason = '';
    }
}
