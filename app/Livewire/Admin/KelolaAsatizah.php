<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaAsatizah extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $perPageNonGuru = '15', $search, $searchNonGuru;
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';

    public $selectUsers = [];

    public function render()
    {

        // Guru
        $guru = User::role('guru');

        if ($this->search) {
            $guru->where('name', 'like', '%' . $this->search . '%');
        }
        $guru = $guru->orderBy('name')
            ->paginate($this->perPage);

        //non guru
        $nonGuru = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'guru');
        });

        if ($this->searchNonGuru) {
            $nonGuru->where('name', 'like', '%' . $this->searchNonGuru . '%');
        }

        $nonGuru = $nonGuru->orderBy('name')
            ->paginate($this->perPageNonGuru);

        return view('livewire.admin.kelola-asatizah', [
            'guru' => $guru,
            'nonGuru' => $nonGuru,
        ])->layout('layouts.app');
    }

    public function addGuru($id)
    {
        $user = User::find($id);
        $user->assignRole('guru');
        $this->alert('success', 'Data berhasil ditambahkan');

    }
    public function revokeGuru($id)
    {
        $user = User::find($id);
        $user->removeRole('guru');
        $this->alert('success', 'Data berhasil direvoke');

    }
    public function addSelected()
    {

        foreach ($this->selectUsers as $ids) {
            $user = User::find($ids);
            $user->assignRole('guru');
        }
        $this->selectUsers = [];

        $this->alert('success', 'Data berhasil ditambahkan');

    }
}
