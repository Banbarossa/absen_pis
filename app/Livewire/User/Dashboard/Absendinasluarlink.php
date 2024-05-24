<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenkaryawan;
use App\Models\Absenkaryawandetail;
use App\Models\Bagianuser;
use App\Models\Jamkaryawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Absendinasluarlink extends Component
{
    public function render()
    {
        $bagianId = Auth::user()->bagianuser_id;
        if ($bagianId) {
            $bagianUser = Bagianuser::find($bagianId);
            $jamAbsen = Jamkaryawan::where('bagianuser_id', $bagianId)->latest()->first();

        }

        $absenToday = Absenkaryawan::whereDate('created_at', Carbon::now()->toDateString())->first();

        $absenmasuk1 = Absenkaryawandetail::where('absenkaryawan_id', $absenToday->id)
            ->where('type', 'masuk_1')->first();

        $absenmasuk2 = Absenkaryawan::whereDate('created_at', Carbon::now()->toDateString())
            ->whereHas('Absenkaryawandetails', function ($query) {
                $query->where('type', 'masuk_2');
            })->first();
        $absenpulang = Absenkaryawan::whereDate('created_at', Carbon::now()->toDateString())
            ->whereHas('Absenkaryawandetails', function ($query) {
                $query->where('type', 'pulang');
            })->first();

        return view('livewire.user.dashboard.absendinasluarlink', compact('jamAbsen', 'absenmasuk1', 'absenmasuk2', 'absenpulang'));
    }
}
