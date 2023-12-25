<?php

namespace App\Livewire\Admin\Welcome;

use App\Models\Knowledge;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Pengetahuan extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $info = Knowledge::latest()->first();
        $infos = Knowledge::latest()->limit(10)->paginate(5);
        return view('livewire.admin.welcome.pengetahuan', ['info' => $info, 'infos' => $infos])->layout('layouts.app');
    }

    public function destroy($id)
    {
        Knowledge::find($id)->delete();
        $this->alert('success', 'Data Berhasil dihapus');

    }
}
