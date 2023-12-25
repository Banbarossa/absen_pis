<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class MusyrifHalaqah extends Component
{

    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $perPageNonMusyrif = '15', $search, $searchNonMusyrif;
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';

    public $selectUsers = [];

    public function render()
    {

        // musyrif halaqah
        $musyrifHalaqah = User::role('musyrif halaqah');

        if ($this->search) {
            $musyrifHalaqah->where('name', 'like', '%' . $this->search . '%');
        }
        $musyrifHalaqah = $musyrifHalaqah->orderBy('name')
            ->paginate($this->perPage);

        //non Musyrif
        $nonMusyrifHalaqah = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'musyrif halaqah');
        });

        if ($this->searchNonMusyrif) {
            $nonMusyrifHalaqah->where('name', 'like', '%' . $this->searchNonMusyrif . '%');
        }

        $nonMusyrifHalaqah = $nonMusyrifHalaqah->orderBy('name')
            ->paginate($this->perPageNonMusyrif);

        return view('livewire.admin.musyrif-halaqah', [
            'musyrifHalaqah' => $musyrifHalaqah,
            'nonMusyrifHalaqah' => $nonMusyrifHalaqah,
        ])->layout('layouts.app');
    }

    public function addMusyrif($id)
    {
        $user = User::find($id);
        $user->assignRole('musyrif halaqah');
        $this->alert('success', 'Data berhasil ditambahkan');

    }
    public function revokeMusyrif($id)
    {
        $user = User::find($id);
        $user->removeRole('musyrif halaqah');
        $this->alert('success', 'Data berhasil ditambahkan');

    }
    public function addSelected()
    {
        foreach ($this->selectUsers as $ids) {
            $user = User::find($ids);
            $user->assignRole('musyrif halaqah');
        }
        $this->selectUsers = [];

        $this->alert('success', 'Data berhasil ditambahkan');

    }
}
