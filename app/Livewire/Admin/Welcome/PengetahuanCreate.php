<?php

namespace App\Livewire\Admin\Welcome;

use App\Models\Knowledge;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PengetahuanCreate extends Component
{
    use LivewireAlert;
    public $pengetahuan_id, $title, $content;
    public function mount($id = false)
    {
        if ($id) {
            $info = Knowledge::find($id);
            $this->pengetahuan_id = $id;
            $this->title = $info->title;
            $this->content = $info->content;

        }
    }
    public function render()
    {
        return view('livewire.admin.welcome.pengetahuan-create')->layout('layouts.app');
    }

    public function store()
    {
        $validation = $this->validate([
            'title' => 'required|min:10',
            'content' => 'required|min:10',
        ]);

        Knowledge::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => 'No Image',
        ]);
        $this->alert('success', 'Data Berhasil ditambahkan');
        return redirect()->route('pengajaran.pengetahuan');
    }

    public function update()
    {
        $validation = $this->validate([
            'title' => 'required|min:10',
            'content' => 'required|min:10',
        ]);

        Knowledge::find($this->informasi_id)->update($validation);
        $this->alert('success', 'Data Berhasil diubah');
        return redirect()->route('pengajaran.pengetahuan');
    }
}
