<?php

namespace App\Livewire\Admin;

use App\Models\Rombel;
use App\Models\Schedule;
use App\Models\Sekolah;
use App\Models\Semester;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaRombel extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'tingkat_kelas';
    public $sortDirection = 'asc';
    public $rombel_id, $nama_rombel, $sekolah_id, $tingkat_kelas, $latitude, $longitude, $radius;
    public $openForm = false;
    public $openFormEdit = false;
    public $getJenjangSekolah;
    public $schedule_id, $dataSchedules;
    public $semesterAktif;

    public function mount()
    {
        $this->semesterAktif = Semester::whereStatus(1)->first()->id;
    }
    #[Layout('layouts.app')]
    public function render()
    {

        $sekolah = Sekolah::orderBy('nama')->get();

        $model = Rombel::with('sekolah')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        if ($this->search) {
            $model = Rombel::with('sekolah')
                ->search($this->search)->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage);
        }

        $model->load(['schedules' => function ($query) {
            $query->where('semester_id', $this->semesterAktif)->get();
        }]);

        if ($this->sekolah_id) {
            $this->getJenjangSekolah = Sekolah::findOrFail($this->sekolah_id)->jenjang;
        }

        return view('livewire.admin.kelola-rombel', [
            'model' => $model,
            'sekolah' => $sekolah,
        ]);
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function rules()
    {
        return [
            'sekolah_id' => 'required',
            'nama_rombel' => 'required',
            'tingkat_kelas' => 'required|numeric',
        ];

    }

    public function create()
    {
        $this->validate();

        $model = new Rombel();
        $model->kode_rombel = Str::uuid();
        $model->sekolah_id = $this->sekolah_id;
        $model->nama_rombel = $this->nama_rombel;
        $model->tingkat_kelas = $this->tingkat_kelas;
        $model->latitude = $this->latitude;
        $model->longitude = $this->longitude;
        $model->radius = $this->radius;
        $model->tingkat_kelas = $this->tingkat_kelas;
        $model->save();

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {

        $rombel = Rombel::findOrFail($id);
        $this->rombel_id = $id;
        $this->sekolah_id = $rombel->sekolah_id;
        $this->nama_rombel = $rombel->nama_rombel;
        $this->tingkat_kelas = $rombel->tingkat_kelas;
        $this->latitude = $rombel->latitude;
        $this->longitude = $rombel->longitude;
        $this->radius = $rombel->radius;

    }

    public function clear()
    {

        $this->sekolah_id = '';
        $this->nama_rombel = '';
        $this->tingkat_kelas = '';
        $this->rombel_id = '';
        $this->latitude = '';
        $this->longitude = '';
        $this->radius = '';
    }

    public function editData()
    {
        $sekolah = Rombel::findOrFail($this->rombel_id);
        $sekolah->update([
            'sekolah_id' => $this->sekolah_id,
            'nama_rombel' => $this->nama_rombel,
            'tingkat_kelas' => $this->tingkat_kelas,
        ]);
        $this->clear();
        $this->alert('success', 'Success is diubah');
        $this->dispatch('close-modal');

    }

    public function destroy($id)
    {
        Rombel::findOrFail($id)->delete();
        $this->alert('success', 'Data Berhasil Dihapus');

    }

    public function pilihSchedule($id)
    {
        $this->rombel_id = $id;
        $this->openForm = true;
        $this->dataSchedules = Schedule::all();

    }

    public function saveSchedule()
    {
        $this->validate([
            'schedule_id' => 'required',
        ]);
        $rombel = Rombel::find($this->rombel_id);
        $schedule = Schedule::find($this->schedule_id);
        $semesterId = Semester::where('status', 1)->first()->id;

        $rombel->schedules()->attach($schedule, ['semester_id' => $semesterId]);

        $this->clear();
        $this->schedule_id = '';
        $this->openForm = false;
        $this->alert('success', 'jadwal berhasil di tambahkan');

    }

    public function editSchedule($id)
    {
        $this->rombel_id = $id;
        $this->openFormEdit = true;
        $this->dataSchedules = Schedule::all();
    }

    public function updateSchedules()
    {
        $this->validate([
            'schedule_id' => 'required',
        ]);

        $rombel = Rombel::find($this->rombel_id);
        $schedule = Schedule::find($this->schedule_id);
        $semesterId = Semester::where('status', 1)->first()->id;

        $rombel->schedules()->sync([$schedule->id => ['semester_id' => $semesterId]]);

        $this->clear();
        $this->openFormEdit = false;
        $this->schedule_id = '';
        $this->alert('success', 'jadwal berhasil di ubah');

    }

    public function canAbsen($id)
    {
        $rombel = Rombel::findOrFail($id);
        $rombel->can_absen = !$rombel->can_absen;
        $rombel->save();

        $this->alert('success', 'Data Berhasil ditambahakan');
    }

}
