<?php

namespace App\Livewire\User\Halaqah;

use App\Models\Anggotahalaqah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class RecordHafalan extends Component
{

    #[Layout('layouts.user-layout')]
    #[Title('Record Hafalan')]
    public function render()
    {

        $anggotaHalaqah = Anggotahalaqah::with('groupinghalaqah', 'student')->whereHas('groupinghalaqah', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();

        $response = Http::get('http://api.alquran.cloud/v1/quran/quran-uthmani')->json();
        // $response = Http::get('https://equran.id/api/v2/surat')->json();
        if ($response['code'] == 200 && $response['status'] == 'OK') {
            $surahs = $response['data']['surahs'];
        }

        // dd($response);

        return view('livewire.user.halaqah.record-hafalan', compact('anggotaHalaqah', 'surahs'));
    }
}
