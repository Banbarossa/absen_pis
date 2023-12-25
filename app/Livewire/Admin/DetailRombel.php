<?php

namespace App\Livewire\Admin;

use App\Models\Jammengajar;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\Roster;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class DetailRombel extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rombel_id, $semAktif_id;
    public $perPage = 15;
    public $updateRoster;
    public $roster_id, $hari, $jam_ke, $user_id, $mapel_id, $mulai_kbm, $akhir_kbm;
    public $nama_rombel;

    public function mount($id)
    {
        $this->rombel_id = $id;
        $this->nama_rombel = Rombel::find($id)->nama_rombel;
        $this->semAktif_id = Semester::whereStatus(1)->first()->id;
    }

    public function render()
    {
        $rombel = $this->rombel_id;
        $semAktif = $this->semAktif_id;
        $schedule = Schedule::whereHas('rombels', function ($query) use ($rombel, $semAktif) {
            $query->where('rombel_id', $rombel)->where('semester_id', $semAktif);
        })->first();

        $roster = Roster::join('jammengajars', 'rosters.jammengajar_id', '=', 'jammengajars.id')
            ->where('semester_id', $semAktif)
            ->where('rombel_id', $rombel)
            ->select('rosters.id', 'jammengajars.id as jammengajar_id', 'jammengajars.hari', 'jammengajars.jam_ke', 'jammengajars.mulai_kbm', 'jammengajars.akhir_kbm', 'rosters.user_id', 'rosters.mapel_id')
            ->orderBy('jammengajars.hari')->orderBy('jammengajars.jam_ke')->with(['user', 'mapel']);

        $jamMengajarInRosterIds = $roster->get()->pluck('jammengajar_id');

        $jammengajarNotInRoster = Jammengajar::where('schedule_id', $schedule->id)->whereNotIn('id', $jamMengajarInRosterIds)->orderBy('hari')->get();

        $roster = $roster->paginate($this->perPage);

        $guru = User::role('guru')->orderBy('name')->get();
        $mapels = Mapel::whereStatus(1)->orderBy('mata_pelajaran')->get();

        return view('livewire.admin.detail-rombel', [
            'schedule' => $schedule,
            'roster' => $roster,
            'jammengajarNotInRoster' => $jammengajarNotInRoster,
            'guru' => $guru,
            'mapels' => $mapels,
        ])->layout('layouts.app');
    }

    public function generateJadwal($id)
    {

        $jammengajar = Jammengajar::where('schedule_id', $id)->get();
        foreach ($jammengajar as $jam) {
            Roster::create([
                'jammengajar_id' => $jam->id,
                'semester_id' => $this->semAktif_id,
                'rombel_id' => $this->rombel_id,
            ]);
        }

        $this->alert('success', 'Data Jadwal Berhasil di generate');
    }

    public function destroy($id)
    {
        Roster::find($id)->delete();
        $this->alert('success', 'Data Roster berhasil di hapus');
    }

    public function addJamToRoster($id)
    {
        $jam = Jammengajar::find($id);
        Roster::create([
            'jammengajar_id' => $jam->id,
            'semester_id' => $this->semAktif_id,
            'rombel_id' => $this->rombel_id,
        ]);
        $this->alert('success', 'Data berhasil ditambahkan');

        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $roster = Roster::with('jammengajar')->find($id);
        $this->roster_id = $id;
        $this->hari = $roster->jammengajar->hari;
        $this->jam_ke = $roster->jammengajar->jam_ke;
        $this->mulai_kbm = $roster->jammengajar->mulai_kbm;
        $this->akhir_kbm = $roster->jammengajar->akhir_kbm;
        $this->user_id = $roster->user_id;
        $this->mapel_id = $roster->mapel_id;

    }

    public function editRoster()
    {

        $this->validate([
            'user_id' => 'required',
            'mapel_id' => 'required',
        ]);

        $roster = Roster::find($this->roster_id);

        $roster->update([
            'user_id' => $this->user_id,
            'mapel_id' => $this->mapel_id,
        ]);

        $this->clear();
        $this->alert('success', 'Data berhasil di Perbaharui');
        $this->dispatch('close-modal');
    }

    public function clear()
    {
        $this->roster_id = '';
        $this->hari = '';
        $this->jam_ke = '';
        $this->user_id = '';
        $this->mapel_id = '';
        $this->mulai_kbm = '';
        $this->akhir_kbm = '';

    }
}
