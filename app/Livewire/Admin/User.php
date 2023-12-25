<?php

namespace App\Livewire\Admin;

use App\Models\User as UserModel;
use Illuminate\Console\View\Components\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'name';
    public $sortDirection = 'asc';
    public $user_id;

    public $name, $email;

    public function render()
    {

        $model = UserModel::orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        if ($this->search) {
            $model = UserModel::search($this->search)->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        }

        return view('livewire.admin.user', ['model' => $model])
            ->layout('layouts.app');
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

    }

    public function updateUser()
    {
        $user = UserModel::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        $this->alert('success', 'Data Berhasil di Update');

    }

    public function nonAktifUser($id)
    {
        $user = UserModel::find($id);
        $user->update(['status' => false]);
        $this->alert('success', 'Data Berhasil di Update ');

    }

    public function aktif($id)
    {
        $user = UserModel::find($id);
        $user->update(['status' => true]);
        $this->alert('success', 'Data Berhasil di Update ');
    }

    public function destroy($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        $this->alert('success', 'User Berhasil dihapus');
    }
}
