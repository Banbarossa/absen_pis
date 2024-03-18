<?php

namespace App\Livewire\Hrd;

use App\Models\Absenhalaqah;
use App\Models\Absensekolah;
use App\Models\Sekolah;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class LaporanBulanan extends Component
{
    public $startDate, $endDate;
    public $user_id;
    public $hadir_halaqah, $sakit_halaqah, $izin_dinas_halaqah, $izin_pribadi_halaqah, $alpa_halaqah;
    public $rekapDataPerSekolah = [];
    public $guru;
    // public $absen_mengajar, $absen_halaqah;
    public $absenPerMusyrif = [];

    public function mount()
    {

        $now = Carbon::now();

        $this->startDate = $now->startOfMonth()->toDateString();

        $this->endDate = $now->endOfMonth()->toDateString();
    }

    public function render()
    {
        // halaqah
        $halaqah = Absenhalaqah::with('jadwalhalaqah')
        // ->where('user_id', $this->user_id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get();

        dd($this->user_id);

        $this->hadir_halaqah = $halaqah->where('kehadiran', 'hadir')->count();
        $this->sakit_halaqah = $halaqah->where('kehadiran', 'sakit')->count();
        $this->izin_dinas_halaqah = $halaqah->where('kehadiran', 'izin dinas')->count();
        $this->izin_pribadi_halaqah = $halaqah->where('kehadiran', 'izin pribadi')->count();
        $this->alpa_halaqah = $halaqah->where('kehadiran', 'alpa')->count();

        // Rekap Absen Sekolah
        $sekolahs = Sekolah::all();
        foreach ($sekolahs as $sekolah) {
            $mengajar = Absensekolah::where('user_id', $this->user_id)
                ->where('sekolah_id', $sekolah->id)
                ->whereBetween('tanggal', [$this->startDate, $this->endDate])
                ->get();

            $honorSekolah = $sekolah->honor;

            $this->rekapDataPerSekolah[$sekolah->nama]['hadir_mengajar'] = $mengajar->where('kehadiran', 'hadir')->sum('jumlah_jam') ?? 0;
            $this->rekapDataPerSekolah[$sekolah->nama]['sakit_mengajar'] = $mengajar->where('kehadiran', 'sakit')->sum('jumlah_jam') ?? 0;
            $this->rekapDataPerSekolah[$sekolah->nama]['izin_dinas_mengajar'] = $mengajar->where('kehadiran', 'izin dinas')->sum('jumlah_jam') ?? 0;
            $this->rekapDataPerSekolah[$sekolah->nama]['izin_pribadi_mengajar'] = $mengajar->where('kehadiran', 'izin pribadi')->sum('jumlah_jam') ?? 0;
            $this->rekapDataPerSekolah[$sekolah->nama]['alpa_mengajar'] = $mengajar->where('kehadiran', 'alpa')->sum('jumlah_jam') ?? 0;

            $this->rekapDataPerSekolah[$sekolah->nama]['honor'] = $honorSekolah;

        }

        $absen_mengajar = Absensekolah::with('rombel')->where('user_id', $this->user_id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get();

        $tanggalUnik = $absen_mengajar->where('kehadiran', 'hadir')->pluck('tanggal')->unique();
        $jumlahHarihadir = $tanggalUnik->count();

        $users = User::where('status', 1)->orderBy('name')
            ->where(function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'guru')
                        ->orWhere('name', 'musyrif halaqah');
                });
            })->get();

        return view('livewire.hrd.laporan-bulanan', [
            'users' => $users,
            'absenPerMusyrif' => $halaqah,
            'absen_mengajar' => $absen_mengajar,
            'jumlahHarihadir' => $jumlahHarihadir,
        ])->layout('layouts.app');
    }

    public function rekap($id)
    {
        $this->user_id = $id;

        $this->guru = User::find($id);

        // //halaqah
        // $halaqah = Absenhalaqah::with('jadwalhalaqah')
        //     ->where('user_id', $id)
        //     ->where('tanggal', '>=', $this->startDate)
        //     ->where('tanggal', '<=', $this->endDate)
        //     ->get();

        // $this->absenPerMusyrif = $halaqah;

        // $this->hadir_halaqah = $halaqah->where('kehadiran', 'hadir')->count();
        // $this->sakit_halaqah = $halaqah->where('kehadiran', 'sakit')->count();
        // $this->izin_dinas_halaqah = $halaqah->where('kehadiran', 'izin dinas')->count();
        // $this->izin_pribadi_halaqah = $halaqah->where('kehadiran', 'izin pribadi')->count();
        // $this->alpa_halaqah = $halaqah->where('kehadiran', 'alpa')->count();

        // $sekolahs = Sekolah::all();
        // foreach ($sekolahs as $sekolah) {
        //     $mengajar = Absensekolah::where('user_id', $id)
        //         ->where('sekolah_id', $sekolah->id)
        //         ->whereBetween('tanggal', [$this->startDate, $this->endDate])
        //         ->get();

        //     $this->rekapDataPerSekolah[$sekolah->nama]['hadir_mengajar'] = $mengajar->where('kehadiran', 'hadir')->sum('jumlah_jam') ?? 0;
        //     $this->rekapDataPerSekolah[$sekolah->nama]['sakit_mengajar'] = $mengajar->where('kehadiran', 'sakit')->sum('jumlah_jam') ?? 0;
        //     $this->rekapDataPerSekolah[$sekolah->nama]['izin_dinas_mengajar'] = $mengajar->where('kehadiran', 'izin dinas')->sum('jumlah_jam') ?? 0;
        //     $this->rekapDataPerSekolah[$sekolah->nama]['izin_pribadi_mengajar'] = $mengajar->where('kehadiran', 'izin pribadi')->sum('jumlah_jam') ?? 0;
        //     $this->rekapDataPerSekolah[$sekolah->nama]['alpa_mengajar'] = $mengajar->where('kehadiran', 'alpa')->sum('jumlah_jam') ?? 0;

        // }

        // $this->absen_mengajar = Absensekolah::with('rombel')->where('user_id', $id)
        //     ->where('sekolah_id', $sekolah->id)
        //     ->whereBetween('tanggal', [$this->startDate, $this->endDate])
        //     ->get();

    }

}
