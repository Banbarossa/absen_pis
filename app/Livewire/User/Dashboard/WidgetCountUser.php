<?php

namespace App\Livewire\User\Dashboard;

use App\Models\User;
use Livewire\Component;

class WidgetCountUser extends Component
{
    public function render()
    {
        $aktif = User::where('status', true)->count();
        $pegawai = User::where('status', true)->where('is_karyawan', true)->count();
        $nonPegawai = User::where('status', true)->where('is_karyawan', false)->count();
        return view('livewire.user.dashboard.widget-count-user', compact('aktif', 'pegawai', 'nonPegawai'));
    }
}
