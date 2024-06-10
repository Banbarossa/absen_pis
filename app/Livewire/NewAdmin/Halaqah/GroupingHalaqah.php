<?php

namespace App\Livewire\NewAdmin\Halaqah;

use App\Models\Anggotahalaqah;
use App\Models\Groupinghalaqah as ModelsGroupinghalaqah;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class GroupingHalaqah extends Component
{

    use LivewireAlert;

    #[Layout('layouts.user-layout')]
    #[Title('Halaqah')]

    public $user_id;
    public $nama_halaqah;

    public $search;

    #[On('halaqah-updated')]
    public function render()
    {
        $halaqah = ModelsGroupinghalaqah::with('user')
            ->when($this->search, function ($query) {
                $query->where('nama_halaqah', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('nama_halaqah')->get();

        foreach ($halaqah as $item) {
            $count = Anggotahalaqah::where('groupinghalaqah_id', $item->id)->count();
            $item->jumlah_anggota = $count;
        }

        return view('livewire.new-admin.halaqah.grouping-halaqah', compact('halaqah'));
    }

    public function changeStatus($id)
    {
        $halaqah = ModelsGroupinghalaqah::findOrfail($id);

        $halaqah->status = !$halaqah->status;
        $halaqah->save();
    }

}
