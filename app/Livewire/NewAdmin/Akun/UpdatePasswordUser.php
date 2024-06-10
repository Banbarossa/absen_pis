<?php

namespace App\Livewire\NewAdmin\Akun;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UpdatePasswordUser extends Component
{

    use LivewireAlert;
    public User $user;

    public $password;
    public $password_confirmation;

    public function render()
    {
        return view('livewire.new-admin.akun.update-password-user');
    }

    public function store()
    {
        $this->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        $this->user->password = Hash::make($this->password);

        $this->alert('success', 'Password Berhasil diperbaharui');
    }
}
