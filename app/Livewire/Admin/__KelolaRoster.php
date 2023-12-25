<?php

namespace App\Livewire\Admin;

use App\Models\Jammengajar;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\Roster;
use App\Models\Semester;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaRoster extends Component
{

    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $rombel_id = 1;
    public $schedule_id;
    public $kode_hari = 1;
    public $semesterAktif;

    public $jammengajar_id, $user_id, $mapel_id;

    public function mount()
    {
        $this->semesterAktif = Semester::where('status', 1)->first();
        $rombel = Rombel::where('id', $this->rombel_id)
            ->whereHas('schedules', function ($query) {
                $query->where('semester_id', $this->semesterAktif);
            })->get();

        $rombel = Rombel::find($this->rombel_id);
        $schedule = $rombel->schedules()->wherePivot('semester_id', $this->semesterAktif->id)->first();
        if ($schedule) {
            $this->schedule_id = $schedule->id;
        } else {
            $this->schedule_id = '';
        }

    }

    public function render()
    {
        $rombels = Rombel::with(['schedules' => function ($query) {
            $query->wherePivot('semester_id', $this->semesterAktif->id);
        }])->orderBy('tingkat_kelas')
            ->orderBy('nama_rombel')
            ->get();

        $jam = [];

        if ($this->schedule_id) {
            $jam = Jammengajar::with(['rosters' => function ($query) {
                $query->where('semester_id', 1);
            }])
                ->where('schedule_id', $this->schedule_id)
                ->where('hari', $this->kode_hari)
                ->orderBy('jam_ke')
                ->get();
        }

        return view('livewire.admin.kelola-roster', [
            'rombels' => $rombels,
            'jam' => $jam,
            'users' => User::orderBy('name')->get(),
            'mapels' => Mapel::orderBy('mata_pelajaran')->get(),
        ])->layout('layouts.app');
    }

    public function getRombelId($id)
    {
        $this->rombel_id = $id;
        $rombel = Rombel::find($id);
        $schedule = $rombel->schedules()->wherePivot('semester_id', $this->semesterAktif->id)->first();

        if ($schedule) {
            $this->schedule_id = $schedule->id;
        } else {
            $this->schedule_id = '';
        }

    }

    public function gantiHari($id)
    {

        $this->kode_hari = $id;
    }

    public function getJamId($id)
    {
        $this->jammengajar_id = $id;
        // dd($id);
    }

    // $table->foreignId('jammengajar_id')->constrained()->cascadeOnDelete();
    // $table->foreignId('semester_id')->nullable();
    // $table->foreignId('rombel_id')->nullable();
    // $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    // $table->foreignId('mapel_id')->constrained()->cascadeOnDelete();

    public function save($id)
    {
        Roster::create([
            "jammengajar_id" => $id,
            "semester_id" => Semester::whereStatus(1)->first()->id,
            "rombel_id" => $this->rombel_id,
            "user_id" => $this->user_id,
            "mapel_id" => $this->mapel_id,
        ]);
        $this->alert('success', 'data berhasil ditambahkan');
    }
}
