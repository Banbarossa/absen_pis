<?php

namespace App\Livewire\Hrd;

use App\Models\Bagianuser;
use App\Models\JadwalHalaqah;
use App\Models\Jamkaryawan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
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
    public $jamkerja_id;
    public $nama_jam_kerja;
    public $jam_masuk_1;
    public $mulai_absen_masuk_1;
    public $akhir_absen_masuk_1;
    public $jam_masuk_2;
    public $mulai_absen_masuk_2;
    public $akhir_absen_masuk_2;
    public $jam_pulang;
    public $mulai_absen_pulang;
    public $akhir_absen_pulang;
    public $toleransi;
    public $ischeckouttomorrow = false;
    public $bagianId;
    #[Layout('layouts.app')]
    #[Title('Jam Absen')]
    public function render()
    {
        $models = Jamkaryawan::with('bagianuser')
            ->when($this->bagianId, function ($query) {
                $query->where('bagianuser_id', $this->bagianId);
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        $bagians = Bagianuser::orderby('name')->get();

        return view('livewire.hrd.jam-absen-karyawan', [
            'models' => $models,
            'bagians' => $bagians,
        ]);
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function getBagianUserId($id)
    {
        $this->bagianId = $id;
    }

    public function clearBagianUserId()
    {
        $this->bagianId = null;
    }

    public function rules()
    {

        return [
            'nama_jam_kerja' => 'required',
            'jam_masuk_1' => 'required',
            'mulai_absen_masuk_1' => 'required',
            'akhir_absen_masuk_1' => 'required',
            'jam_masuk_2' => 'required',
            'mulai_absen_masuk_2' => 'required',
            'akhir_absen_masuk_2' => 'required',
            'jam_pulang' => 'required',
            'mulai_absen_pulang' => 'required',
            'akhir_absen_pulang' => 'required',
            'toleransi' => 'nullable|number',
        ];

    }

    public function create()
    {
        $this->validate();

        JadwalHalaqah::create([
            'nama_jam_kerja' => $this->nama_jam_kerja,
            'jam_masuk_1' => $this->jam_masuk_1,
            'mulai_absen_masuk_1' => $this->mulai_absen_masuk_1,
            'akhir_absen_masuk_1' => $this->akhir_absen_masuk_1,
            'jam_masuk_2' => $this->jam_masuk_2,
            'mulai_absen_masuk_2' => $this->mulai_absen_masuk_2,
            'akhir_absen_masuk_2' => $this->akhir_absen_masuk_2,
            'jam_pulang' => $this->jam_pulang,
            'mulai_absen_pulang' => $this->mulai_absen_pulang,
            'akhir_absen_pulang' => $this->akhir_absen_pulang,
            'toleransi' => $this->toleransi,
            'ischeckouttomorrow' => $this->ischeckouttomorrow,
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
        $this->jam_masuk_1 = $jam_karyawan->jam_masuk_1;
        $this->mulai_absen_masuk_1 = $jam_karyawan->mulai_absen_masuk_1;
        $this->akhir_absen_masuk_1 = $jam_karyawan->akhir_absen_masuk_1;
        $this->jam_masuk_2 = $jam_karyawan->jam_masuk_2;
        $this->mulai_absen_masuk_2 = $jam_karyawan->mulai_absen_masuk_2;
        $this->akhir_absen_masuk_2 = $jam_karyawan->akhir_absen_masuk_2;
        $this->jam_pulang = $jam_karyawan->jam_pulang;
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
            'jam_masuk_1' => $this->jam_masuk_1,
            'mulai_absen_masuk_1' => $this->mulai_absen_masuk_1,
            'akhir_absen_masuk_1' => $this->akhir_absen_masuk_1,
            'jam_masuk_2' => $this->jam_masuk_2,
            'mulai_absen_masuk_2' => $this->mulai_absen_masuk_2,
            'akhir_absen_masuk_2' => $this->akhir_absen_masuk_2,
            'jam_pulang' => $this->jam_pulang,
            'mulai_absen_pulang' => $this->mulai_absen_pulang,
            'akhir_absen_pulang' => $this->akhir_absen_pulang,
            'toleransi' => $this->toleransi,
            'ischeckouttomorrow' => $this->ischeckouttomorrow,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Di ubah');
        $this->dispatch('close-modal');

    }

    public function clear()
    {
        $this->jamkerja_id = "";
        $this->nama_jam_kerja = "";
        $this->jam_masuk_1 = "";
        $this->mulai_absen_masuk_1 = "";
        $this->akhir_absen_masuk_1 = "";
        $this->jam_masuk_2 = "";
        $this->mulai_absen_masuk_2 = "";
        $this->akhir_absen_masuk_2 = "";
        $this->jam_pulang = "";
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
