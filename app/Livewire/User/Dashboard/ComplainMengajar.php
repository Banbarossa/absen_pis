<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absensekolah;
use App\Models\Complainmengajar as ModelsComplainmengajar;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ComplainMengajar extends Component
{

    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Complain Absen Mengajar')]

    public $absen;

    public $change_to;
    public $reason;

    public function mount($absen)
    {

        $user = Auth::user();
        $absen = Absensekolah::with('rombel', 'mapel')->find($absen);

        $this->absen = $absen;

        if (!$absen || $absen->user_id != $user->id) {
            return abort(404);
        }

    }

    public function render()
    {
        return view('livewire.user.dashboard.complain-mengajar');
    }

    public function rules()
    {
        return [
            'reason' => 'required',
            'change_to' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => 'Alasan tidak Absen wajib diisi',
            'change_to.required' => 'Permohonan perubahan wajib diisi',
        ];
    }
    public function store()
    {
        $this->validate();

        $complain = new ModelsComplainmengajar();
        $complain->absensekolah_id = $this->absen->id;
        $complain->change_to = $this->change_to;
        $complain->reason = $this->reason;
        $complain->save();

        session()->flash('success', 'Complain Absen Berhasil diajukan');
        return redirect()->route('v2.dashboard');

    }
}
