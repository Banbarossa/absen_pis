<?php

namespace App\Livewire\User\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UpdatePassword extends Component
{
    use LivewireAlert;

    public $old_password, $new_password, $password_confirmation;
    public function render()
    {
        return view('livewire.user.profile.update-password');
    }

    public function store()
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
            'password' => Hash::make($this->new_password),
        ]);

        $this->alert('success', 'Password berhasil Di Update');
    }
}
