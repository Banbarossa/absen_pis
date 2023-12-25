<?php

namespace App\Livewire\Admin\Security;

use App\Models\Absensecurityceklokasi;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanSecurity extends Component
{

    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $startDate, $endDate;
    public $perPage = 15, $search;

    public function mount()
    {
        $today = Carbon::now();
        $this->startDate = $today->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfDay()->toDateString();
    }
    public function render()
    {

        $model = Absensecurityceklokasi::with('securelocation')->whereBetween('tanggal', [$this->startDate, $this->endDate])->paginate($this->perPage);
        return view('livewire.admin.security.laporan-security', [
            'models' => $model,
        ])->layout('layouts.app');
    }
}
