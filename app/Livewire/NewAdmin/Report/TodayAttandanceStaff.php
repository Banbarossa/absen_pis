<?php

namespace App\Livewire\NewAdmin\Report;

use App\Models\Absenkaryawan;
use App\Models\User;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TodayAttandanceStaff extends Component
{
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Kehadiran Pegawai')]

    public $date;

    public $today;
    public function mount()
    {
        $this->date = Carbon::now()->toDateString();
        $this->today = Carbon::now()->toDateString();
    }

    public function render()
    {

        $absen = Absenkaryawan::with('absenkaryawandetails', 'user')
            ->whereDate('tanggal', $this->date)
            ->join('users', 'absenkaryawans.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('absenkaryawans.*', 'users.name as user_name')
            ->get();

        $userNotScan = User::where('is_karyawan', true)->whereDoesntHave('absenkaryawans', function ($query) {
            $query->whereDate('tanggal', $this->date);
        })
            ->orderBy('name', 'asc')
            ->get();

        $absen->each(function ($item) {
            $item->masuk_1 = $item->absenkaryawandetails->where('type', 'masuk_1')->first();
            $item->masuk_2 = $item->absenkaryawandetails->where('type', 'masuk_2')->first();
            $item->pulang = $item->absenkaryawandetails->where('type', 'pulang')->first();
        });
        return view('livewire.new-admin.report.today-attandance-staff', compact('absen', 'userNotScan'));
    }

    public function previousDate()
    {
        $this->date = Carbon::createFromFormat('Y-m-d', $this->date)->subDay()->toDateString();
    }

    public function nextDate()
    {
        $this->date = Carbon::createFromFormat('Y-m-d', $this->date)->addDay()->toDateString();
    }
}
