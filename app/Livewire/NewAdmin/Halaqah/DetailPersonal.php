<?php

namespace App\Livewire\NewAdmin\Halaqah;

use App\Charts\RekapKehadiranPersonalMusyrif;
use App\Models\Absenhalaqah;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetailPersonal extends Component
{

    #[Layout('layouts.user-layout')]
    #[Title('Detail Personal')]
    public $startDate;
    public $endDate;
    public $user_id;

    public function mount($user_id, $startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->user_id = decrypt($user_id);
    }

    public function render(RekapKehadiranPersonalMusyrif $chart)
    {

        $absen = Absenhalaqah::with('jadwalhalaqah')->where('user_id', $this->user_id)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get();

        $type_kehadiran = ['hadir', 'izin dinas', 'izin pribadi', 'sakit', 'alpa'];

        $dataset = [];
        foreach ($type_kehadiran as $type) {
            $dataset[] = $absen->where('kehadiran', $type)->count();
        }
        $user = User::findOrFail($this->user_id);

        $data = [
            'title' => 'Kehadiran ' . ucWords($user->name),
            'setSubtitle' => 'Periode ' . $this->startDate . ' s/d ' . $this->endDate,
            'dataset' => $dataset,
            'labels' => $type_kehadiran,
        ];

        $chart = $chart->build($data);
        return view('livewire.new-admin.halaqah.detail-personal', compact('absen', 'chart', 'user'));
    }

    // "user_id" => 20
    // "jadwal_halaqah_id" => 2
    // "tanggal" => "2024-05-14"
    // "waktu_absen" => "19:19:23"
    // "kehadiran" => "hadir"
    // "in_location" => 0
    // "latitude" => null
    // "longitude" => null
    // "image" => "664356cbef80c.png"
    // "created_by" => null
}
