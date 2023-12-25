<?php

namespace App\Livewire\Admin\Security;

use App\Models\SecureLocation;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LokasiAbsen extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 15, $search;
    public $sortColumn = 'tingkat_kelas';
    public $sortDirection = 'asc';
    public $secure_lokasi_id;
    public $nama_lokasi, $start_scan, $end_scan, $latitude, $longitude;

    public function render()
    {

        $lokasi = SecureLocation::paginate($this->perPage);
        return view('livewire.admin.security.lokasi-absen', ['lokasi' => $lokasi])->layout('layouts.app');
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function clear()
    {
        $this->secure_lokasi_id = '';
    }

    public function create()
    {

        SecureLocation::create([
            'nama_lokasi' => $this->nama_lokasi,
            'kode_lokasi' => Str::uuid(),
            'start_scan' => $this->start_scan,
            'end_scan' => $this->end_scan,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        $this->alert('success', 'Data berhasil ditambah');

    }

    public function edit($id)
    {
        $this->secure_lokasi_id = $id;
    }

    public function editData()
    {
        SecureLocation::findOrfail($this->secure_lokasi_id)->update([
            'nama_lokasi' => $this->nama_lokasi,
            'start_scan' => $this->start_scan,
            'end_scan' => $this->end_scan,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);
        $this->clear();
        $this->alert('success', 'Data berhasil diubah');
    }

}
