<?php

namespace App\Livewire\Hrd;

use App\Models\JadwalHalaqah;
use App\Models\Jamkaryawan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class JamAbsenKaryawan extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'nama_jam_kerja';
    public $sortDirection = 'asc';
    public $jamkerja_id, $nama_jam_kerja, $jam_masuk, $jam_pulang, $mulai_absen_masuk, $akhir_absen_masuk, $mulai_absen_pulang, $akhir_absen_pulang, $toleransi;

    public function render()
    {
        $model = Jamkaryawan::orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        if ($this->search) {
            $model = Jamkaryawan::search($this->search)->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        }
        return view('livewire.hrd.jam-absen-karyawan', [
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
            'nama_jam_kerja' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'mulai_absen_masuk' => 'required',
            'akhir_absen_masuk' => 'required',
            'mulai_absen_pulang' => 'required',
            'akhir_absen_pulang' => 'required',
            'toleransi' => 'required',
        ];

    }

    public function create()
    {
        $this->validate();

        JadwalHalaqah::create([
            'nama_jam_kerja' => $this->nama_jam_kerja,
            'jam_masuk' => $this->jam_masuk,
            'jam_pulang' => $this->jam_pulang,
            'mulai_absen_masuk' => $this->mulai_absen_masuk,
            'akhir_absen_masuk' => $this->akhir_absen_masuk,
            'mulai_absen_pulang' => $this->mulai_absen_pulang,
            'akhir_absen_pulang' => $this->akhir_absen_pulang,
            'toleransi' => $this->toleransi,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');

    }

    public function edit($id)
    {
        $this->jamkerja_id = $id;
        $jam_karyawan = Jamkaryawan::findOrFail($id);
        $this->nama_jam_kerja = $jam_karyawan->nama_jam_kerja;
        $this->jam_masuk = $jam_karyawan->jam_masuk;
        $this->jam_pulang = $jam_karyawan->jam_pulang;
        $this->mulai_absen_masuk = $jam_karyawan->mulai_absen_masuk;
        $this->akhir_absen_masuk = $jam_karyawan->akhir_absen_masuk;
        $this->mulai_absen_pulang = $jam_karyawan->mulai_absen_pulang;
        $this->akhir_absen_pulang = $jam_karyawan->akhir_absen_pulang;
        $this->toleransi = $jam_karyawan->toleransi;

    }

    public function editData()
    {
        $this->validate();
        $jam_karyawan = Jamkaryawan::findOrFail($this->jamkerja_id);
        $jam_karyawan->update([
            'nama_jam_kerja' => $this->nama_jam_kerja,
            'jam_masuk' => $this->jam_masuk,
            'jam_pulang' => $this->jam_pulang,
            'mulai_absen_masuk' => $this->mulai_absen_masuk,
            'akhir_absen_masuk' => $this->akhir_absen_masuk,
            'mulai_absen_pulang' => $this->mulai_absen_pulang,
            'akhir_absen_pulang' => $this->akhir_absen_pulang,
            'toleransi' => $this->toleransi,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Di ubah');
        $this->dispatch('close-modal');

    }

    public function clear()
    {
        $this->jamkerja_id = "";
        $this->nama_jam_kerja = "";
        $this->jam_masuk = "";
        $this->jam_pulang = "";
        $this->mulai_absen_masuk = "";
        $this->akhir_absen_masuk = "";
        $this->mulai_absen_pulang = "";
        $this->akhir_absen_pulang = "";
        $this->toleransi = "";

    }

    public function destroy($id)
    {
        $jam_karyawan = Jamkaryawan::findOrFail($id);
        $jam_karyawan->delete();

        $this->alert('success', 'Data Berhasil di hapus');
    }
}
