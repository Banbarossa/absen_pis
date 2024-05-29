<?php

namespace App\Livewire\Admintail\TugasLuar;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{

    #[Layout('layouts.absen')]
    #[Title('text')]
    public function render()
    {
        return view('livewire.admintail.tugas-luar.index');
    }
}
