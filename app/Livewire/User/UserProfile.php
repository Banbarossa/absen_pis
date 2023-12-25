<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UserProfile extends Component
{
    use LivewireAlert;
    public $name, $email, $password_absen;
    public $old_password, $new_password, $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password_absen = $user->password_absen;

    }

    public function render()
    {
        // $user = Auth::user();
        return view('livewire.user.user-profile')->layout('layouts.app');
    }

    public function updateProfile()
    {

        User::find(Auth::user()->id)->update([
            'name' => $this->name,
            'password_absen' => $this->password_absen,
        ]);

        $this->alert('success', 'Profil berhasil Di Update');
    }
    public function updatePassword()
    {
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password',
            'password_confirmation' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Password lama diperlukan',
            'new_password.required' => 'Password baru diperlukan',
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter',
            'new_password.different' => 'Password baru harus berbeda dengan password lama',
            'password_confirmation.required' => 'Konfirmasi password diperlukan',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password baru',
        ]);

        $user = User::find(Auth::user()->id);

        if (!Hash::check($this->old_password, $user->password)) {
            $this->addError('old_password', 'Password lama salah');
            return;
        }

        $user->update([
            'password' => bcrypt($this->new_password),
        ]);

        $this->alert('success', 'Password berhasil Di Update');
    }
}
