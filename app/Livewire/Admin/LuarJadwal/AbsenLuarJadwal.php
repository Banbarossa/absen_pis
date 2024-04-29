<?php

namespace App\Livewire\Admin\LuarJadwal;

use App\Models\Absensekolah;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\User;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AbsenLuarJadwal extends Component
{

    use LivewireAlert;

    public $user_id;
    public $jam_ke;
    public $mulai_kbm;
    public $akhir_kbm;
    public $rombel_id;
    public $sekolah_id;
    public $mapel_id;
    public $waktu_absen;
    public $jumlah_jam;

    public $tanggal;
    #[Layout('layouts.app')]

    public function mount()
    {
        $this->jumlah_jam = 2;
        $this->tanggal = Carbon::now()->toDateString();
    }

    public function render()
    {
        $users = User::where('status', 1)->orderBy('name')
            ->where(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'guru');
                });
            })->get();

        $rombels = Rombel::orderBy('tingkat_kelas')->get();
        $mapels = Mapel::whereStatus(true)->orderBy('mata_pelajaran')->get();

        return view('livewire.admin.luar-jadwal.absen-luar-jadwal', compact('users', 'rombels', 'mapels'));
    }

    public function store()
    {
        $this->validate([
            'user_id' => 'required',
            'jam_ke' => 'required',
            'mulai_kbm' => 'required',
            'akhir_kbm' => 'required',
            'rombel_id' => 'required',
            'mapel_id' => 'required',
            // 'waktu_absen' => 'required',
            'jumlah_jam' => 'required',
        ]);

        $rombel = Rombel::where('id', $this->rombel_id)->first();
        $sekolah_id = $rombel->sekolah_id;

        Absensekolah::create([
            'user_id' => $this->user_id,
            'tanggal' => $this->tanggal,
            'jam_ke' => $this->jam_ke,
            'mulai_kbm' => $this->mulai_kbm,
            'akhir_kbm' => $this->akhir_kbm,
            'rombel_id' => $this->rombel_id,
            'sekolah_id' => $sekolah_id,
            'mapel_id' => $this->mapel_id,
            'waktu_absen' => Carbon::now()->format('H:i:s'),
            'kehadiran' => 'hadir',
            'jumlah_jam' => $this->jumlah_jam,
        ]);

        $this->clear();

        $this->alert('success', 'Data Berhasil ditambahkan');

    }

    public function clear()
    {

        $this->user_id = '';
        $this->jam_ke = '';
        $this->mulai_kbm = '';
        $this->akhir_kbm = '';
        $this->rombel_id = '';
        $this->sekolah_id = '';
        $this->mapel_id = '';
        $this->waktu_absen = '';
    }
}
