<?php

namespace App\Livewire\NewAdmin\Halaqah;

use App\Models\Groupinghalaqah;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class GroupingHalaqahUpdate extends Component
{
    use LivewireAlert;

    #[Layout('layouts.user-layout')]
    #[Title('Update Halaqah')]

    public Groupinghalaqah $group;

    public $nama_halaqah;
    public $user_id;

    public function mount($group)
    {
        $this->nama_halaqah = $group->nama_halaqah;
        $this->user_id = $group->user_id;
    }

    public function render()
    {
        $user = User::role('musyrif halaqah')->orderBy('name', 'asc')->get();
        return view('livewire.new-admin.halaqah.grouping-halaqah-update', compact('user'));
    }

    public function store()
    {
        $this->validate([
            'nama_halaqah' => 'required',
            'user_id' => 'required',
        ]);

        $this->group->nama_halaqah = $this->nama_halaqah;
        $this->group->user_id = $this->user_id;
        $this->group->save();

        $this->redirect(route('v2.halaqah'), navigate: true);
        $this->alert('success', 'Data Berhasil diperbaharui');
    }
}
