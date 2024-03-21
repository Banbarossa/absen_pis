<?php

namespace App\Livewire\Admin;

use App\Models\Absenhalaqah;
use App\Models\Complainhalaqah;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaComplainHalaqah extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'tanggal';
    public $sortDirection = 'desc';
    public $dataToChange = [];
    public $selectSemua;

    #[Layout('layouts.app')]
    public function render()
    {
        // $model = Complainhalaqah::with([
        //     'absenhalaqah.jadwalhalaqah' => function ($query) {
        //         $query->select('id', 'nama_sesi');
        //     },
        // ])
        //     ->join('absenhalaqahs', 'complainhalaqahs.absenhalaqah_id', '=', 'absenhalaqahs.id')
        //     ->join('users', 'absenhalaqahs.user_id', '=', 'users.id')
        //     ->select('complainhalaqahs.id', 'complainhalaqahs.change_to', 'complainhalaqahs.reason', 'complainhalaqahs.status', 'absenhalaqahs.tanggal', 'users.name');

        // $model = Complainhalaqah::with(['absenhalaqah.jadwalhalaqah', 'absenhalaqah.user'])->latest()->limit(10)->paginate(5);

        // if ($this->search) {
        //     $model->where(function ($query) {
        //         $query->where('tanggal', 'like', '%' . $this->search . '%');
        //         // ->orwhere('name', 'like', '%' . $this->search . '%');
        //     });
        // }

        // $model = $model->take(15)->paginate($this->perPage);

        $model = Complainhalaqah::with(['absenhalaqah.jadwalhalaqah', 'absenhalaqah.user'])->latest()->limit(150)->paginate($this->perPage);

        return view('livewire.admin.kelola-complain-halaqah', [
            'model' => $model,
        ]);
    }

    public function terimaComplain($id)
    {
        $data = Complainhalaqah::find($id);

        $absen = Absenhalaqah::find($data->absenhalaqah_id);

        $absen->update([
            'kehadiran' => $data->change_to,
        ]);

        $data->update(['status' => 1]);
        $this->alert('success', 'Complain berhasil diterima');

    }

    public function tolakComplain($id)
    {
        $data = Complainhalaqah::find($id)->update(['status' => 0]);

        $this->alert('success', 'Complain dibehasil ditolak');

    }

    public function selectAll()
    {
        if ($this->selectSemua == 1) {
            $this->dataToChange = Complainhalaqah::where('status', null)->pluck('id');
        } else {
            $this->dataToChange = [];
        }

    }

    public function terimaBanyak()
    {
        foreach ($this->dataToChange as $data) {
            $complain = Complainhalaqah::find($data);

            Absenhalaqah::find($complain->absenhalaqah_id)->update(['kehadiran' => $complain->change_to]);

            $complain->update(['status' => 1]);
            $this->alert('success', 'Complain berhasil diterima');
        }
        $this->dataToChange = [];
        $this->alert('success', 'Complain berhasil diterima');

    }

    public function tolakBanyak()
    {
        foreach ($this->dataToChange as $data) {
            $data = Complainhalaqah::find($data)->update(['status' => 0]);
        }
        $this->alert('success', 'Complain dibehasil ditolak');
        $this->alert('success', 'Complain berhasil diterima');
    }

}
