<?php

namespace App\Livewire\User\Dashboard;

use App\Models\Absenhalaqah;
use App\Models\Complainhalaqah as ModelsComplainhalaqah;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ComplainHalaqah extends Component
{

    use LivewireAlert;
    #[Layout('layouts.user-layout')]
    #[Title('Complain Absen Halaqah')]

    public $absen;

    public $change_to;
    public $reason;

    public function mount($absen)
    {

        $user = Auth::user();
        $absen = Absenhalaqah::with('jadwalhalaqah')->find($absen);

        $this->absen = $absen;

        if (!$absen || $absen->user_id != $user->id) {
            return abort(404);
        }

    }
    public function render()
    {

        return view('livewire.user.dashboard.complain-halaqah');
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

        dd($this->change_to, $this->reason);
        $this->validate();

        $complain = new ModelsComplainhalaqah();
        $complain->absenhalaqah_id = $this->absen->id;
        $complain->change_to = $this->change_to;
        $complain->reason = $this->reason;
        $complain->save();

        session()->flash('success', 'Complain Absen Berhasil diajukan');
        return redirect()->route('v2.dashboard');

    }
}
