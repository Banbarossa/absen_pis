<?php

namespace App\Livewire\Hrd;

use App\Models\Bagianuser;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class GroupingUserToBagian extends Component
{
    use LivewireAlert;
    #[Layout('layouts.app')]
    #[Title('Kelola bagian')]

    public $name;

    public $lokasi;

    public $radius;

    public $perpage = 15;

    public $selectUsers = [];

    public $bagianId;

    public function render()
    {

        $bagians = Bagianuser::orderby('name')->get();
        $users = User::where('is_karyawan', true)
            ->wherenull('bagianuser_id')
            ->orderBy('name')->paginate($this->perpage);
        $userbagian = collect();
        if ($this->bagianId) {
            $userbagian = User::where('is_karyawan', true)->where('bagianuser_id', $this->bagianId)->get();
        }

        return view('livewire.hrd.grouping-user-to-bagian', compact('bagians', 'users', 'userbagian'));
    }

    public function storeBagian()
    {

        $this->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama Bagian Wajib Diisi',
        ]);

        Bagianuser::create([
            'name' => $this->name,
            'lokasi' => $this->lokasi,
            'radius' => $this->radius,
        ]);

        $this->alert('success', 'Data berhasil ditambahkan');
    }

    public function clear()
    {
        $this->name = '';
    }

    public function addSelected()
    {
        if (is_null($this->bagianId)) {
            $this->alert('error', 'Pilih Bagian yang mau di Assign');
            return;
        }

        foreach ($this->selectUsers as $ids) {
            $user = User::find($ids);
            $user->bagianuser_id = $this->bagianId;
            $user->save();
        }
        $this->selectUsers = [];
        $this->alert('success', 'Berhasil di ubah');
    }

    public function assignSiggleRole($id)
    {
        if (is_null($this->bagianId)) {
            $this->alert('error', 'Pilih Bagian yang mau di Assign');
            return;
        }

        $user = User::find($id);
        $user->bagianuser_id = $this->bagianId;
        $user->save();
        $this->alert('success', 'Berhasil di ubah');

    }

    public function selectBagianId($id)
    {
        $this->bagianId = $id;
    }

    public function kosongkanBagian($id)
    {
        $user = User::find($id);
        $user->bagianuser_id = null;
        $user->save();
        $this->alert('success', 'Data berhasil diperbaharui');
    }
}
