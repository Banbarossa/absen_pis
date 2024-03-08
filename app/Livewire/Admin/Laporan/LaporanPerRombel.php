<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\Absensekolah;
use App\Models\Rombel;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanPerRombel extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $startDate, $endDate;
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $change_to, $reason, $absensekolah_id, $rombel_id = 5;
    public $user_id, $nama_guru;

    #[Layout('layouts.app')]

    public function mount()
    {
        // $this->sekolah_id = $id;
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->toDateString();
    }

    public function render()
    {

        $absensekolah = Absensekolah::with(['user', 'rombel', 'mapel'])
            ->where('tanggal', '>=', $this->startDate)
            ->where('tanggal', '<=', $this->endDate)
            ->where('rombel_id', $this->rombel_id)
            ->paginate($this->perPage);

        $rombel = Rombel::orderBy('tingkat_kelas', 'asc')->get();

        return view('livewire.admin.laporan.laporan-per-rombel', compact('absensekolah', 'rombel'));
    }

    public function hapus($id)
    {
        Absensekolah::find($id)->delete();
        $this->alert('success', 'Data Berhasil dihapus');
    }

    public function changeRombel($id)
    {
        $this->rombel_id = $id;
    }
}
