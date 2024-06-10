<?php

namespace App\Livewire\Admin;

use App\Models\Semester;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class PengaturanSemester extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'tahun';
    public $sortDirection = 'asc';
    public $nama_semester, $tahun, $semester_id;
    public $status = 0;

    #[Layout('layouts.app')]
    #[Title('Pengaturan Semester')]
    public function render()
    {
        $model = Semester::latest()->paginate($this->perPage);
        if ($this->search) {
            $model = Semester::search($this->search)->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        }

        return view('livewire.admin.pengaturan-semester', [
            'model' => $model,
        ]);
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function rules()
    {
        return [
            'nama_semester' => 'required',
            'tahun' => 'required|min:9',
        ];
    }

    public function create()
    {
        $this->validate();

        Semester::create([
            'nama_semester' => $this->nama_semester,
            'tahun' => $this->tahun,
            'status' => $this->status,
        ]);

        $this->clear();
        $this->alert('success', 'Data Berhasil Ditambahkan');
        $this->dispatch('close-modal');
    }

    public function clear()
    {

        $this->nama_semester = '';
        $this->tahun = '';
        $this->status = '';
        $this->semester_id = '';
    }

    public function edit($id)
    {
        $jenjang = Semester::findOrFail($id);
        $this->semester_id = $id;
        $this->nama_semester = $jenjang->nama_semester;
        $this->tahun = $jenjang->tahun;
    }

    public function editData()
    {
        $jenjang = Semester::findOrFail($this->semester_id);
        $jenjang->update([
            'nama_semester' => $this->nama_semester,
            'tahun' => $this->tahun,
            'status' => $this->status,
        ]);
        $this->clear();
        $this->alert('success', 'Success is diubah');
        $this->dispatch('close-modal');

    }

    public function destroy($id)
    {
        Semester::findOrFail($id)->delete();
        $this->alert('success', 'Data Berhasil Dihapus');

    }

    public function aktifkan($id)
    {
        $semesters = Semester::all();

        foreach ($semesters as $semester) {
            $semester->update(['status' => false]);
        }

        Semester::findOrFail($id)->update([
            'status' => true,
        ]);
        $this->clear();
        $this->alert('success', 'Success is diaktifkan');

    }
}
