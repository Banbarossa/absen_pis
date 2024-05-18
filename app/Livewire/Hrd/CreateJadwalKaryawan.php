<?php

namespace App\Livewire\Hrd;

use App\Models\Jamkaryawan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateJadwalKaryawan extends Component
{

    use LivewireAlert;

    #[Layout('layouts.app')]
    #[Title('Jam Karyawan')]

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

    public $bagianuser_id;

    public $ischeckouttomorrow = false;

    public function mount($id)
    {
        $this->bagianuser_id = $id;
    }

    public function render()
    {
        return view('livewire.hrd.create-jadwal-karyawan');
    }

    public function store()
    {

        $this->validate([
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
            'toleransi' => 'required',
            'ischeckouttomorrow' => 'required|boolean',
        ]);

        Jamkaryawan::create([
            'bagianuser_id' => $this->bagianuser_id,
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

        $this->alert('success', 'Data Berhasil ditambahkan');
        return redirect()->route('admin.pengaturan.jam-karyawan');
    }

    public function updateischeckouttomorrow()
    {
        $this->ischeckouttomorrow = !$this->ischeckouttomorrow;
    }

}
