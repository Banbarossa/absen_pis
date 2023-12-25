<?php

namespace App\Livewire\Admin;

use App\Models\Jammengajar;
use App\Models\Schedule;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class KelolaSchedule extends Component
{
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search, $hari = 1;
    public $sortColumn = 'jam_ke';
    public $sortDirection = 'asc';
    public $schedule_id, $new_schedule;
    public $jam_id;

    public $jam_ke, $mulai_kbm, $akhir_kbm, $mulai_absen, $akhir_absen, $jumlah_jam;

    public function mount()
    {
        $this->schedule_id = Schedule::latest()->first()->id;
    }

    public function render()
    {
        $model = Schedule::where('status', true)->get();

        $jamMengajar = Jammengajar::where('hari', $this->hari)
            ->where('schedule_id', $this->schedule_id)
            ->orderBy($this->sortColumn, $this->sortDirection)->get();

        if ($this->search) {
            $jamMengajar = Jammengajar::search($this->search)
                ->where('hari', $this->hari)
                ->where('schedule_id', $this->schedule_id)
                ->orderBy($this->sortColumn, $this->sortDirection)->get();
        }

        return view('livewire.admin.kelola-schedule', [
            'model' => $model,
            'jamMengajar' => $jamMengajar,
        ])->layout('layouts.app');
    }

    public function gantiHari($id)
    {
        $this->hari = $id;
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function getScheduleId($id)
    {
        $this->schedule_id = $id;
    }

    public function rules()
    {
        return [
            'jam_ke' => 'required',
            'mulai_kbm' => 'required',
            'akhir_kbm' => 'required',
            // 'mulai_absen' => 'required',
            // 'akhir_absen' => 'required',
            'jumlah_jam' => 'required|digits:1',
        ];
    }

    public function create()
    {
        $this->validate();
        $mulai_kbm = Carbon::parse($this->mulai_kbm);
        $mulai_absen = $mulai_kbm->subMinutes(10);

        $akhir_kbm = Carbon::parse($this->akhir_kbm);
        $akhir_absen = $akhir_kbm->subMinutes(15);

        Jammengajar::create([
            'schedule_id' => $this->schedule_id,
            'hari' => $this->hari,
            'jam_ke' => $this->jam_ke,
            'mulai_kbm' => $this->mulai_kbm,
            'akhir_kbm' => $this->akhir_kbm,
            'mulai_absen' => $mulai_absen,
            'akhir_absen' => $akhir_absen,
            'jumlah_jam' => $this->jumlah_jam,
        ]);
        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');
    }

    public function clear()
    {
        $this->jam_ke = '';
        $this->mulai_kbm = '';
        $this->akhir_kbm = '';
        $this->mulai_absen = '';
        $this->akhir_absen = '';
        $this->jumlah_jam = '';

    }

    public function edit($id)
    {
        $jam = Jammengajar::findOrFail($id);
        $this->schedule_id = $jam->schedule_id;
        $this->jam_id = $id;
        $this->hari = $jam->hari;
        $this->jam_ke = $jam->jam_ke;
        $this->mulai_kbm = $jam->mulai_kbm;
        $this->akhir_kbm = $jam->akhir_kbm;
        $this->mulai_absen = $jam->mulai_absen;
        $this->akhir_absen = $jam->akhir_absen;
        $this->jumlah_jam = $jam->jumlah_jam;

    }

    public function editData()
    {
        $mulai_kbm = Carbon::parse($this->mulai_kbm);
        $mulai_absen = $mulai_kbm->subMinutes(10);

        $akhir_kbm = Carbon::parse($this->akhir_kbm);
        $akhir_absen = $akhir_kbm->subMinutes(15);

        Jammengajar::findOrFail($this->jam_id)->update([
            'jam_ke' => $this->jam_ke,
            'mulai_kbm' => $this->mulai_kbm,
            'akhir_kbm' => $this->akhir_kbm,
            'mulai_absen' => $mulai_absen,
            'akhir_absen' => $akhir_absen,
            'jumlah_jam' => $this->jumlah_jam,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');

    }

    public function destroy($id)
    {
        Jammengajar::findOrFail($id)->delete();
        $this->alert('success', 'Data Berhasil Dihapus');

    }

    public function addJadwal()
    {
        $this->validate([
            'new_schedule' => 'required',
        ], [
            'new_schedule.required' => 'Nama Jadwal Tidak Boleh Kosong',
        ]);

        Schedule::create([
            'name' => $this->new_schedule,
        ]);

        $this->new_schedule = '';
        $this->alert('success', 'Data berhasil ditambahkan');

    }

    public function nonaktifkanSchedule($id)
    {
        $schedule = Schedule::find($id);

        $schedule->update([
            'status' => false,
        ]);
        $this->alert('success', 'Data berhasil dihapus');
    }
}
