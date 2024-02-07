<?php

namespace App\Livewire\Piket;

use App\Models\Absenalternatif;
use App\Models\Absensekolah;
use App\Models\Rombel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaAbsenAlternatif extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $startDate, $endDate, $search;

    public $perPage = 15;
    public $singleAbsen;

    public $selectAbsens = [];

    public $alasan_penolakan;

    public function mount()
    {

        $now = Carbon::now();

        $this->startDate = $now->startOfMonth()->toDateString();

        $this->endDate = $now->endOfMonth()->toDateString();
    }

    public function render()
    {
        if ($this->search) {

        }
        $absen = Absenalternatif::with('user', 'rombel')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.piket.kelola-absen-alternatif', [
            'absens' => $absen,
        ])->layout('layouts.app');
    }

    public function getAbsen($id)
    {
        $this->singleAbsen = Absenalternatif::with('user', 'rombel')->find($id);
    }

    public function destroy($id)
    {
        Absenalternatif::find($id)->delete();
        $this->singleAbsen = '';
        $this->alert('success', 'Data Berhasil dihapus');
    }

    public function destroySelected()
    {
        foreach ($this->selectAbsens as $absen_id) {
            Absenalternatif::find($absen_id)->delete();
        }
        $this->selectAbsens = [];
        $this->alert('success', 'Data terpilih Berhasil dihapus');
    }

    public function terima($id)
    {

        $absen = Absenalternatif::find($id)->update([
            'approved' => true,
            'approved_by' => Auth::user()->id,
        ]);

        $absen = Absenalternatif::find($id);
        $rombel = Rombel::find($absen->rombel_id);
        Absensekolah::create([
            'user_id' => $absen->user_id,
            'tanggal' => $absen->tanggal,
            'jam_ke' => 'alternatif',
            'rombel_id' => $absen->rombel_id,
            'sekolah_id' => $rombel->sekolah_id,
            'waktu_absen' => $absen->waktu_absen,
            'jumlah_jam' => $absen->jumlah_jam,
            'kehadiran' => 'hadir',
            'absenalternatif_id' => $absen->id,
            'image' => $absen->image,
        ]);
        $this->dispatch('close-modal');
        $this->singleAbsen = '';
        $this->alert('success', 'Absen Alternatif Berhasil diterima');
    }

    public function terimaSelected()
    {

        foreach ($this->selectAbsens as $absen_id) {
            $absen = Absenalternatif::find($absen_id)->update([
                'approved' => true,
                'approved_by' => Auth::user()->id,
            ]);
            $absen = Absenalternatif::find($absen_id);
            $rombel = Rombel::find($absen->rombel_id);
            Absensekolah::create([
                'user_id' => $absen->user_id,
                'tanggal' => $absen->tanggal,
                'jam_ke' => 'alternatif',
                'rombel_id' => $absen->rombel_id,
                'sekolah_id' => $rombel->sekolah_id,
                'waktu_absen' => $absen->waktu_absen,
                'jumlah_jam' => $absen->jumlah_jam,
                'kehadiran' => 'hadir',
                'absenalternatif_id' => $absen->id,
                'image' => $absen->image,
            ]);

        }

        $this->selectAbsens = [];
        $this->alert('success', 'Absen terpilih Berhasil diterima');
    }

    public function tolak()
    {
        Absenalternatif::find($this->singleAbsen->id)->update([
            'approved' => false,
            'approved_by' => Auth::user()->id,
            'alasan_penolakan' => $this->alasan_penolakan,
        ]);
        $this->singleAbsen = '';
        $this->alert('success', 'Absen Alternatif Berhasil ditolak');
    }
    public function tolakSelected()
    {

        foreach ($this->selectAbsens as $absen_id) {
            Absenalternatif::find($absen_id)->update([
                'approved' => false,
                'approved_by' => Auth::user()->id,
                'alasan_penolakan' => $this->alasan_penolakan,
            ]);
        }

        $this->selectAbsens = [];
        $this->alert('success', 'Absen terpilih Berhasil ditolak');
    }

    public function clear()
    {

    }

    public function close()
    {
        $this->dispatch('close-modal');
    }
}
