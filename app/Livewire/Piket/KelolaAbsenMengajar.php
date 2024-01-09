<?php

namespace App\Livewire\Piket;

use App\Models\Absenalternatif;
use App\Models\Absensekolah;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaAbsenMengajar extends Component
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
        $now = Carbon::now();

        $absens = Absensekolah::with('rombel', 'mapel', 'absenalternatif')
            ->where('tanggal', $now->toDateString())
            ->where('mulai_kbm', '<=', $now->format('H:i:s'))
            ->paginate('15');

        return view('livewire.piket.kelola-absen-mengajar', [
            'absens' => $absens,
        ])->layout('layouts.app');
    }

    public function clear()
    {

    }

    public function getAbsenSekolahId($id)
    {
        $this->absensekolah_id = $id;
    }
    public function update()
    {

        Absensekolah::findOrFail($this->absensekolah_id)->update([
            'kehadiran' => $this->kehadiran,
        ]);

        $this->alert('success', 'Data berhasil diubah');
    }

    public function absenAlternatif($id)
    {
        $absen = Absenalternatif::find($id);
        $this->alasan = $absen->alasan;
    }
}
