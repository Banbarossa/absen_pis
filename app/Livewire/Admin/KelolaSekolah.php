<?php

namespace App\Livewire\Admin;

use App\Models\Sekolah;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaSekolah extends Component
{

    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';
    public $selectedKelas = [];

    public $sekolah_id;

    public $npsn, $nama, $user_id, $jenjang;

    public function render()
    {
        $model = Sekolah::orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        if ($this->search) {
            $model = Sekolah::search($this->search)->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        }
        $users = User::orderBy('name')->get();

        return view('livewire.admin.kelola-sekolah', [
            'model' => $model,
            'users' => $users,
        ])->layout('layouts.app');
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function rules()
    {
        return [
            'npsn' => 'required|min:8',
            'nama' => 'required|min:3',
            'jenjang' => 'required',
        ];
    }

    public function create()
    {
        $this->validate();

        $model = new Sekolah();
        $model->npsn = $this->npsn;
        $model->nama = $this->nama;
        $model->user_id = $this->user_id;
        $model->jenjang = $this->jenjang;
        $model->save();

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $this->sekolah_id = $id;
        $this->npsn = $sekolah->npsn;
        $this->nama = $sekolah->nama;
        $this->jenjang = $sekolah->jenjang;
        $this->user_id = $sekolah->user_id;

    }

    public function clear()
    {

        $this->npsn = '';
        $this->nama = '';
        $this->user_id = '';
        $this->jenjang = '';
        $this->sekolah_id = '';
    }

    public function editData()
    {
        $sekolah = Sekolah::findOrFail($this->sekolah_id);
        $sekolah->update([
            'npsn' => $this->npsn,
            'nama' => $this->nama,
            'user_id' => $this->user_id,
            'jenjang' => $this->jenjang,
        ]);
        $this->clear();
        $this->alert('success', 'Success is diubah');
        $this->dispatch('close-modal');

    }

    public function destroy($id)
    {
        Sekolah::findOrFail($id)->delete();
        $this->alert('success', 'Data Berhasil Dihapus');

    }

}
