<?php

namespace App\Livewire;

use App\Models\Absensekolah;
use App\Models\Rombel;
use App\Models\User;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AbsenMengajarBarcode extends Component
{
    use LivewireAlert;
    public $test;
    public $latitude, $longitude;
    public $isInRadius;
    public $allowedAbsen;
    public $image;
    public $password_absen;

    // protected $listeners = ['latitudeUpdated', 'longitudeUpdated'];

    public $codeRomble;
    public $absen_id, $user_name, $nama_rombel, $jam_ke, $mapel;

    public function mount($id)
    {
        $this->codeRomble = $id;
    }

    public function render()
    {
        return view('livewire.absen-mengajar-barcode')->layout('layouts.guest');
    }

    // public function updatedLatitude($value)
    // {
    //     $this->hitungRadius();
    // }

    // public function updatedLongitude($value)
    // {
    //     $this->hitungRadius();
    // }

    public function hitungRadius()
    {

        $allowedLatitude = 5.463151;
        $allowedLongitude = 95.386354;

        // Jarak maksimal yang diizinkan dalam meter
        $maxDistance = 1000;

        $earthRadius = 6371; // Radius Bumi dalam kilometer
        $dLat = deg2rad($allowedLatitude - $this->latitude);
        $dLon = deg2rad($allowedLongitude - $this->longitude);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($this->latitude)) * cos(deg2rad($allowedLatitude)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c * $maxDistance; // Jarak dalam meter

        // Periksa apakah pengguna berada dalam radius yang diizinkan
        if ($distance <= $maxDistance) {
            $this->isInRadius = true;
        } else {
            $this->isInRadius = false;
        }

    }
    public function confirmation()
    {
        dd($this->latitude, $this->longitude);
        // $this->hitungRadius();
        // $password_absen = $this->password_absen;
        $user = User::where('password_absen', $this->password_absen)->first();
        if (!$user) {
            return $this->alert('error', 'Password Anda Keliru, Coba Lagi', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true]);
        }
        $now = Carbon::now();
        $rombel = Rombel::where('kode_rombel', $this->codeRomble)->first();

        $absen = Absensekolah::with('user')->where('tanggal', $now->toDateString())
            ->where('rombel_id', $rombel->id)
            ->where('mulai_kbm', '<=', $now->format('H:i:s'))->where('akhir_kbm', '>=', $now->format('H:i:s'))
            ->where('user_id', $user->id)->first();

        if ($absen) {
            $this->absen_id = $absen->id;
            $this->user_name = $absen->user->name;
            $this->nama_rombel = $rombel->nama_rombel;
            $this->jam_ke = $absen->jam_ke;
            $this->mapel = $absen->mapel->mata_pelajaran;

        } else {

            $this->alert('error', 'Anda tidak punya Akses, atau diluar jadwal yang ditentukan', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true]);

        }

    }

    public function absensi()
    {
        $absen = Absensekolah::find($this->absen_id);
        // mulai_kbm
        $now = Carbon::now();
        $mulaiKBM = Carbon::parse($absen->mulai_kbm);
        $allowedTime = env('MENIT_DISPENSASI', 10);
        $dispensasiTime = $mulaiKBM->addMinutes($allowedTime);
        $keterlambatanInterval = $now->diff($dispensasiTime);
        $keterlambatan = $keterlambatanInterval->h * 60 + $keterlambatanInterval->i + $keterlambatanInterval->s / 60;

        $absen->update([
            'waktu_absen' => $now->format('H:i:s'),
            'kehadiran' => 'hadir',
            'keterlambatan' => $keterlambatan,
            'in_location' => $this->isInRadius,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        $this->alert('success', 'hi !, ' . strtoupper($this->user_name) . ' Anda berhasil melakukan Absen. terima kasih', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true]);
        return redirect('/login');
    }

}
