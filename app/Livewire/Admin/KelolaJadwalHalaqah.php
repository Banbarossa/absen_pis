<?php

namespace App\Livewire\Admin;

use App\Models\JadwalHalaqah;
use Illuminate\Console\View\Components\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaJadwalHalaqah extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'hari';
    public $sortDirection = 'asc';
    public $jadwal_halaqah_id, $hari, $nama_sesi, $mulai_absen, $akhir_absen, $insentif;

    public function render()
    {
        $model = JadwalHalaqah::where('nama_sesi', '!=', 'khusus')->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        if ($this->search) {
            $model = JadwalHalaqah::search($this->search)->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        }

        return view('livewire.admin.kelola-jadwal-halaqah', [
            'model' => $model,
        ])->layout('layouts.app');
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function rules()
    {
        return [
            'hari' => 'required',
            'nama_sesi' => 'required',
            'mulai_absen' => 'required',
            'akhir_absen' => 'required',
        ];

    }

    public function create()
    {
        $this->validate();

        JadwalHalaqah::create([
            'hari' => $this->hari,
            'nama_sesi' => $this->nama_sesi,
            'mulai_absen' => $this->mulai_absen,
            'akhir_absen' => $this->akhir_absen,
            'insentif' => $this->insentif,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');

    }

    public function edit($id)
    {
        $this->jadwal_halaqah_id = $id;
        $jadwal_halaqah = JadwalHalaqah::findOrFail($id);
        $this->hari = $jadwal_halaqah->hari;
        $this->nama_sesi = $jadwal_halaqah->nama_sesi;
        $this->mulai_absen = $jadwal_halaqah->mulai_absen;
        $this->akhir_absen = $jadwal_halaqah->akhir_absen;
        $this->insentif = $jadwal_halaqah->insentif;
    }

    public function editData()
    {
        $this->validate();
        $jadwal_halaqah = JadwalHalaqah::findOrFail($this->jadwal_halaqah_id);
        $jadwal_halaqah->update([
            'hari' => $this->hari,
            'nama_sesi' => $this->nama_sesi,
            'mulai_absen' => $this->mulai_absen,
            'akhir_absen' => $this->akhir_absen,
            'insentif' => $this->insentif,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Di ubah');
        $this->dispatch('close-modal');

    }

    public function clear()
    {
        $this->jadwal_halaqah_id = "";
        $this->hari = "";
        $this->mulai_absen = "";
        $this->akhir_absen = "";
        $this->insentif = "";
    }

    public function destroy($id)
    {
        $jadwal_halaqah = JadwalHalaqah::findOrFail($id);
        $jadwal_halaqah->delete();

        $this->alert('success', 'Data Berhasil di hapus');
    }
}
