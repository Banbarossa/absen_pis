<?php

namespace App\Livewire\NewAdmin\Halaqah;

use App\Models\Groupinghalaqah;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class GroupingHalaqahCreate extends Component
{
    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Tambah Halaqah')]

    public $nama_halaqah;
    public $user_id;

    public function render()
    {
        $user = User::role('musyrif halaqah')->orderBy('name', 'asc')->get();
        return view('livewire.new-admin.halaqah.grouping-halaqah-create', compact('user'));
    }

    public function store()
    {
        $this->validate([
            'user_id' => 'required|numeric',
            'nama_halaqah' => 'required',
        ]);
        Groupinghalaqah::create([
            'user_id' => $this->user_id,
            'nama_halaqah' => $this->nama_halaqah,
            'status' => true,
        ]);
        $this->redirect(route('v2.halaqah'), navigate: true);
        $this->alert('success', 'Halaqah Berhasil ditambahkan');
    }

}
