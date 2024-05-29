<?php

namespace App\Livewire\NewAdmin\Akun;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Pengguna')]

    public function render()
    {

        $ActiveUsers = User::whereStatus(true)->get();
        $inActiveUsers = User::whereStatus(false)->get();
        return view('livewire.new-admin.akun.index', compact('ActiveUsers', 'inActiveUsers'));
    }

    public function changeStatus($id)
    {
        $user = User::findOrfail($id);
        $user->status = !$user->status;
        $user->save();

        $this->alert('success', 'Data Berhasil Diperbaharui');
        return;
    }
}
