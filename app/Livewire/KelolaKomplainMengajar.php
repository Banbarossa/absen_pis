<?php

namespace App\Livewire;

use App\Models\Absensekolah;
use App\Models\Complainmengajar;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaKomplainMengajar extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'tanggal';
    public $sortDirection = 'desc';
    public $dataToChange = [];
    public $selectSemua;

    public function render()
    {
        $model = Complainmengajar::with('absensekolah', 'approvedBy')
            ->join('absensekolahs', 'complainmengajars.absensekolah_id', '=', 'absensekolahs.id')
            ->join('users', 'absensekolahs.user_id', '=', 'users.id')
            ->leftJoin('users as approved_users', 'complainmengajars.approved_by', '=', 'approved_users.id')
            ->select(
                'complainmengajars.id',
                'complainmengajars.change_to',
                'complainmengajars.reason',
                'complainmengajars.status',
                'absensekolahs.tanggal',
                'users.name as user_name',
                'approved_users.name as approved_by_name'
            );

        if ($this->search) {
            $model->where(function ($query) {
                $query->where('tanggal', 'like', '%' . $this->search . '%')
                    ->orwhere('name', 'like', '%' . $this->search . '%');
            });
        }

        $model = $model->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        return view('livewire.kelola-komplain-mengajar', [
            'model' => $model,
        ])->layout('layouts.app');
    }

    public function terimaComplain($id)
    {
        $data = Complainmengajar::find($id);

        $absen = Absensekolah::find($data->absensekolah_id);

        $absen->update([
            'kehadiran' => $data->change_to,
        ]);

        $data->update([
            'status' => 1,
            'approved_by' => Auth::user()->id,
        ]);
        $this->alert('success', 'Complain berhasil diterima');

    }

    public function tolakComplain($id)
    {
        $data = Complainmengajar::find($id)->update(['status' => 0, 'approved_by' => Auth::user()->id]);

        $this->alert('success', 'Complain dibehasil ditolak');

    }

    public function selectAll()
    {
        if ($this->selectSemua == 1) {
            $this->dataToChange = Complainmengajar::where('status', null)->pluck('id');
        } else {
            $this->dataToChange = [];
        }

    }

    public function terimaBanyak()
    {
        foreach ($this->dataToChange as $data) {
            $complain = Complainmengajar::find($data);

            Absensekolah::find($complain->absenhalaqah_id)->update(['kehadiran' => $complain->change_to]);

            $complain->update([
                'status' => 1,
                'approved_by' => Auth::user()->id,
            ]);
            $this->alert('success', 'Complain berhasil diterima');
        }
        $this->dataToChange = [];
        $this->alert('success', 'Complain berhasil diterima');

    }

    public function tolakBanyak()
    {
        foreach ($this->dataToChange as $data) {
            $data = Complainmengajar::find($data)->update(['status' => 0, 'approved_by' => Auth::user()->id]);
        }
        $this->alert('success', 'Complain dibehasil ditolak');
        $this->alert('success', 'Complain berhasil diterima');
    }
}
