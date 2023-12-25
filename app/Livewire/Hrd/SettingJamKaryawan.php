<?php

namespace App\Livewire\Hrd;

use App\Models\Jamkaryawan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class SettingJamKaryawan extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $roleName, $tambahRoleName;
    public $search, $perPage = 15;
    public $selectUsers = [];

    public function mount()
    {
        $role = Role::first();
        $this->roleName = $role->name;
    }

    public function render()
    {
        $roles = Role::all();
        $role_jam = Role::with('jamkaryawans')->where('name', $this->roleName)->first();

        $jamkaryawan = Jamkaryawan::whereDoesntHave('roles', function ($query) {
            $query->where('name', $this->roleName);
        });

        if ($this->search) {
            $jamkaryawan = $jamkaryawan->where(function ($query) {
                $query->where('nama_jam_kerja', 'like', '%' . $this->search . '%');
            });
        }

        $jamkaryawan = $jamkaryawan->paginate($this->perPage);
        return view('livewire.hrd.setting-jam-karyawan', [
            'roles' => $roles,
            'role_jam' => $role_jam,
            'jamkaryawan' => $jamkaryawan,
        ])->layout('layouts.app');
    }

    public function changeRole($id)
    {
        $role = Role::find($id);
        $this->roleName = $role->name;
    }

    public function attachjam($id)
    {
        $jam = Jamkaryawan::find($id);
        $role = Role::whereName($this->roleName)->first();
        $jam->roles()->attach($role);

        $this->alert('success', 'Data berhasil ditambahkan');

    }

    public function detachRole($id)
    {
        $jam = Jamkaryawan::find($id);
        $role = Role::whereName($this->roleName)->first();
        $role->jamkaryawans()->detach($jam->id);
        $this->alert('success', 'Data berhasil dihapus');
    }

}
