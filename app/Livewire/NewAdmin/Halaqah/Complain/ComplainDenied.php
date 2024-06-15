<?php

namespace App\Livewire\NewAdmin\Halaqah\Complain;

use App\Models\Complainhalaqah;
use Livewire\Attributes\On;
use Livewire\Component;

class ComplainDenied extends Component
{

    #[On('complainDenied')]
    public function render()
    {

        $denied = Complainhalaqah::whereStatus(false)
            ->latest()
            ->with(['absenhalaqah.user', 'absenhalaqah.jadwalhalaqah'])
            ->get();

        return view('livewire.new-admin.halaqah.complain.complain-denied', compact('denied'));
    }
}
