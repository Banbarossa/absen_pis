<?php

namespace App\Livewire;

use App\Models\Absenhalaqah;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AbsenHaqalah extends Component
{
    use LivewireAlert;
    public $latitude, $longitude;
    public $isInRadius;
    public $allowedAbsen;
    public $password_absen;

    protected $listeners = ['latitudeUpdated', 'longitudeUpdated'];

    public function render()
    {

        return view('livewire.absen-haqalah')->layout('layouts.guest');
    }

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

    public function updatedLatitude($value)
    {
        $this->hitungRadius();
    }

    public function updatedLongitude($value)
    {
        $this->hitungRadius();
    }

    public function absen()
    {

        $now = Carbon::now();
        $password_absen = $this->password_absen;
        $absen = Absenhalaqah::with('user')->whereHas('jadwalhalaqah', function ($query) use ($now) {
            $query->where('mulai_absen', '<=', $now->format('H:i:s'))->where('akhir_absen', '>=', $now->format('H:i:s'));
        })
            ->where('user_id', $password_absen)
            ->where('tanggal', $now->toDateString())
            ->first();

        if ($absen) {
            $absen->update([
                'waktu_absen' => $now->format('H:i:s'),
                'status_kehadiran' => 'hadir',
                'in_radius' => $this->isInRadius,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);

            $this->alert('success', 'hi !, ' . strtoupper($absen->user->name) . ' Anda berhasil melakukan Absen. terima kasih', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true]);
            return redirect('/login');

        } else {

            $this->alert('error', 'Anda tidak punya Akses, atau diluar jadwal yang ditentukan', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true]);

        }

    }
}
