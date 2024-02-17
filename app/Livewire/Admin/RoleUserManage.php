<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleUserManage extends Component
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
    #[Layout('layouts.app')]
    public function render()
    {
        $roles = Role::all();
        $users = User::role($this->roleName)->orderBy('name')->get();
        $userNotRole = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', $this->roleName);
        });

        if ($this->search) {
            $userNotRole = $userNotRole->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $userNotRole = $userNotRole->paginate($this->perPage);

        return view('livewire.admin.role-user-manage', [
            'roles' => $roles,
            'users' => $users,
            'userNotRole' => $userNotRole,
        ]);
    }

    public function changeRole($id)
    {
        $role = Role::find($id);
        $this->roleName = $role->name;
    }

    public function addRole()
    {
        $this->validate([
            'tambahRoleName' => 'required',
        ]);

        Role::create([
            'name' => $this->tambahRoleName,
        ]);

        $this->tambahRoleName = '';
        $this->Alert('success', 'Data berhasil ditambahkan');
    }
    public function destroyRole($id)
    {
        Role::findOrFail($id)->delete();
        $this->alert('success', 'Role Berhasil dihapus');
    }

    public function assignSiggleRole($id)
    {
        $user = User::find($id);
        $user->assignRole($this->roleName);
        $this->alert('success', 'Data berhasil ditambahkan');

    }

    public function addSelected()
    {

        foreach ($this->selectUsers as $ids) {
            $user = User::find($ids);
            $user->assignRole($this->roleName);
        }
        $this->selectUsers = [];

        $this->alert('success', 'Data berhasil ditambahkan');
    }

    public function revokeRole($id)
    {
        $user = User::find($id);
        $user->removeRole($this->roleName);
        $this->alert('success', 'Data berhasil di revoke');

    }
}
