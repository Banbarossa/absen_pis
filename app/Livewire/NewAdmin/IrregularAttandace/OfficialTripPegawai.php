<?php

namespace App\Livewire\NewAdmin\IrregularAttandace;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class OfficialTripPegawai extends Component
{
    #[Layout('layouts.user-layout')]
    #[Title('')]
    public function render()
    {
        return view('livewire.new-admin.irregular-attandace.official-trip-pegawai');
    }
}
