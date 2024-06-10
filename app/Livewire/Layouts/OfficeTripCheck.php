<?php

namespace App\Livewire\Layouts;

use App\Models\Absendinasluar;
use Livewire\Component;

class OfficeTripCheck extends Component
{
    public function render()
    {

        $jumlah = Absendinasluar::whereNull('approval')->count();

        return view('livewire.layouts.office-trip-check', compact('jumlah'));
    }
}
