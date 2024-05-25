<?php

namespace App\Livewire\User\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{

    use LivewireAlert;
    public $name, $email, $password_absen;

    #[Layout('layouts.user-layout')]
    #[Title('Profile')]

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password_absen = $user->password_absen;

    }
    public function render()
    {

        return view('livewire.user.profile.index');
    }

    public function updateProfile()
    {

        $this->validate([
            'name' => 'required|min:3',
            'password_absen' => 'required|min:6|unique:users,password_absen',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'password_absen.required' => 'Password Absen wajib diisi',
            'password_absen.min' => 'Password Absen minimal 3 karakter',
            'password_absen.unique' => 'Password ini tidak dapat digunakan, silahkan menggunkan yang lain',
        ]);

        User::find(Auth::user()->id)->update([
            'name' => $this->name,
            'password_absen' => $this->password_absen,
        ]);

        $this->alert('success', 'Profil berhasil Di Update');
    }

}
