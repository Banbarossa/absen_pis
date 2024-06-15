<?php

namespace App\Livewire\NewAdmin\Halaqah\Complain;

use App\Models\Complainhalaqah;
use Livewire\Attributes\On;
use Livewire\Component;

class ComplainApproved extends Component
{
    public $jumlahtampil = 20;

    #[On('complainApproved')]
    public function render()
    {
        $approved = Complainhalaqah::with(['absenhalaqah.user', 'absenhalaqah.jadwalhalaqah'])->whereStatus(true)->latest()->take($this->jumlahtampil)->get();

        return view('livewire.new-admin.halaqah.complain.complain-approved', compact('approved'));
    }
}
