<?php

namespace App\Livewire\Admin\Welcome;

use App\Models\Informasi;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class InformasiCreate extends Component
{
    use LivewireAlert;
    public $informasi_id, $title, $content;

    public function mount($id = false)
    {
        if ($id) {
            $info = Informasi::find($id);
            $this->informasi_id = $id;
            $this->title = $info->title;
            $this->content = $info->content;

        }
    }

    public function render()
    {
        return view('livewire.admin.welcome.informasi-create')->layout('layouts.app');
    }

    public function store()
    {
        $validation = $this->validate([
            'title' => 'required|min:10',
            'content' => 'required|min:10',
        ]);

        Informasi::create($validation);
        $this->alert('success', 'Data Berhasil ditambahkan');
        return redirect()->route('pengajaran.informasi');
    }

    public function update()
    {
        $validation = $this->validate([
            'title' => 'required|min:10',
            'content' => 'required|min:10',
        ]);

        Informasi::find($this->informasi_id)->update($validation);
        $this->alert('success', 'Data Berhasil diubah');
        return redirect()->route('pengajaran.informasi');
    }
}
