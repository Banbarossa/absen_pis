<?php

namespace App\Livewire\NewAdmin\Akun;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class UpdateUser extends Component
{

    use LivewireAlert;

    #[Layout('layouts.user-layout')]
    #[Title('Update User')]

    public User $user;

    public $name;
    public $email;
    public $password_absen;

    public function mount($user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password_absen = $user->password_absen;
    }

    public function render()
    {
        return view('livewire.new-admin.akun.update-user');
    }

    public function storeIdentitas()
    {

        $this->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email,' . $this->user->id,
            'password_absen' => 'required|min:5|unique:users,password_absen,' . $this->user->id,
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->password_absen = $this->password_absen;

        $this->user->save();

        $this->alert('success', 'Data perhasil diperbaharui');
    }

}
