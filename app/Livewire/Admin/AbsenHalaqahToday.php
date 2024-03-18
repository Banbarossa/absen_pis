<?php

namespace App\Livewire\Admin;

use App\Models\Absenhalaqah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AbsenHalaqahToday extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $perPage = '15', $search;
    public $sortColumn = 'jadwal_halaqahs.mulai_absen';
    public $sortDirection = 'desc';
    public $startDate, $endDate;

    public $user_id, $jadwal_halaqah_id, $tanggal, $waktu_absen, $created_by, $kehadiran;

    public $absenHalaqah_id;

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(7)->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();
    }

    public function render()
    {
        $today = Carbon::now();
        $model = Absenhalaqah::with('user', 'jadwalhalaqah')
            ->whereHas('jadwalhalaqah', function ($query) {
                $query->where('mulai_absen', '<=', Carbon::now()->format('H:i:s'));
            })
            ->where('tanggal', '=', $today->toDateString())
            ->leftJoin('users', 'absenhalaqahs.user_id', '=', 'users.id')
            ->leftJoin('jadwal_halaqahs', 'absenhalaqahs.jadwal_halaqah_id', '=', 'jadwal_halaqahs.id')
            ->select('absenhalaqahs.*', 'users.name as user_name', 'jadwal_halaqahs.nama_sesi');
        // ->where('jumlah')

        if ($this->search) {
            $model->where(function ($query) {
                $query->where('users.name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('tanggal', 'LIKE', '%' . $this->search . '%');
            });
        }

        $model = $model->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.absen-halaqah-today', [
            'model' => $model,
        ])->layout('layouts.app');
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';

    }

    public function edit($id)
    {
        $absenHalaqah = Absenhalaqah::find($id);
        $this->absenHalaqah_id = $id;
        $this->user_id = $absenHalaqah->user_id;
        $this->jadwal_halaqah_id = $absenHalaqah->jadwal_halaqah_id;
        $this->tanggal = $absenHalaqah->tanggal;

    }

    public function update()
    {

        $this->validate([
            'kehadiran' => 'required',
        ]);
        $absenHalaqah = Absenhalaqah::find($this->absenHalaqah_id);

        $absenHalaqah->update([
            'kehadiran' => $this->kehadiran,
            'created_by' => Auth::user()->id,
        ]);
        $this->alert('success', 'data berhasil dirubah');
        $this->clear();

    }

    public function clear()
    {
        $this->absenHalaqah_id = '';
        $this->user_id = '';
        $this->jadwal_halaqah_id = '';
        $this->tanggal = '';
        $this->waktu_absen = '';
        $this->created_by = '';
        $this->kehadiran = '';

    }

    public function destroy($id)
    {
        Absenhalaqah::findOrFail($id)->delete();
        $this->alert('success', 'data berhasil hapus');
    }
}
