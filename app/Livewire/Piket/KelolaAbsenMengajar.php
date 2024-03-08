<?php

namespace App\Livewire\Piket;

use App\Models\Absenalternatif;
use App\Models\Absensekolah;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
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

    public $tanggal;
    #[Layout('layouts.app')]

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(7)->toDateString();
        $this->endDate = Carbon::now()->toDateString();
        $this->tanggal = Carbon::now()->toDateString();
    }

    public function render()
    {
        $now = Carbon::now();

        $absens = Absensekolah::with('rombel', 'mapel', 'absenalternatif', 'user')
            ->where('tanggal', $this->tanggal)
            ->when($this->tanggal !== $now->toDateString(), function ($query) {
                return $query;
            }, function ($query) use ($now) {
                return $query->where('mulai_kbm', '<=', $now->format('H:i:s'));
            })
        // ->where('mulai_kbm', '<=', $now->format('H:i:s'))
            ->orderBy('jam_ke', 'desc')
            ->orderBy('rombel_id', 'desc')
            ->paginate('15');

        return view('livewire.piket.kelola-absen-mengajar', [
            'absens' => $absens,
        ]);
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
            'kehadiran' => $this->change_to,
        ]);

        $this->alert('success', 'Data berhasil diubah');
        $this->dispatch('close-modal');
    }

    public function absenAlternatif($id)
    {
        $absen = Absenalternatif::find($id);
        $this->alasan = $absen->alasan;
    }

    public function destroy($id)
    {
        Absensekolah::find($id)->delete();
        $this->alert('success', 'Data berhasil dihapus');
    }
}
