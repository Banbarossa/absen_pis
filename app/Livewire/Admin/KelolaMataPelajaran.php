<?php

namespace App\Livewire\Admin;

use App\Models\Mapel;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaMataPelajaran extends Component
{

    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'mata_pelajaran';
    public $sortDirection = 'asc';
    public $selectedKelas = [];

    public $mapel_id;

    public $mata_pelajaran;

    public function render()
    {
        $model = Mapel::whereStatus(true)->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        if ($this->search) {
            $model = Mapel::search($this->search)->paginate($this->perPage);
        }
        $users = User::orderBy('name')->get();
        return view('livewire.admin.kelola-mata-pelajaran', [
            'model' => $model,
        ])
            ->layout('layouts.app');
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function rules()
    {
        return [
            'mata_pelajaran' => 'required|min:2|unique:mapels',
        ];
    }

    public function create()
    {
        $this->validate();

        $model = new Mapel();
        $model->mata_pelajaran = $this->mata_pelajaran;

        $model->save();

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        $this->mapel_id = $id;
        $this->mata_pelajaran = $mapel->mata_pelajaran;

    }

    public function clear()
    {
        $this->mata_pelajaran = '';
        $this->mapel_id = '';
    }

    public function editData()
    {
        $this->validate();
        $mapel = Mapel::findOrFail($this->mapel_id);
        $mapel->update([
            'mata_pelajaran' => $this->mata_pelajaran,
        ]);
        $this->clear();
        $this->alert('success', 'Success is diubah');
        $this->dispatch('close-modal');

    }

    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->update([
            'status' => 0,
        ]);
        $this->alert('success', 'Data Berhasil Dihapus');

    }

    public function changeStatus($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->status = !$mapel->status;
        $mapel->save();
        // $mapel->update([
        //     'status' => !$mapel->status,
        // ]);
        $this->alert('success', 'Data Berhasil Dihapus');
    }
}
