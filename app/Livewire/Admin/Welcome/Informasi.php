<?php

namespace App\Livewire\Admin\Welcome;

use App\Models\Informasi as Info;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Informasi extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $info = Info::latest()->first();
        $infos = Info::latest()->paginate(5);
        return view('livewire.admin.welcome.informasi', ['info' => $info, 'infos' => $infos])->layout('layouts.app');
    }

    public function destroy($id)
    {
        Info::find($id)->delete();
        $this->alert('success', 'Data Berhasil dihapus');

    }
}
