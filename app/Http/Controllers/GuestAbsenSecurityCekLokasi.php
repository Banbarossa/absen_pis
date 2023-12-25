<?php

namespace App\Http\Controllers;

use App\Models\Absensecurityceklokasi;
use App\Models\SecureLocation;
use App\Models\User;
use App\Traits\CekLokasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestAbsenSecurityCekLokasi extends Controller
{
    use CekLokasi;
    public function index($code)
    {
        $now = Carbon::now()->format('H:i:s');

        $lokasi = SecureLocation::where('kode_lokasi', $code)->first();
        $ontime = false;
        if ($now >= $lokasi->start_scan && $now <= $lokasi->end_scan) {
            $ontime = true;
        }

        return view('guest.absen-security-cek-lokasi', [
            'lokasi' => $lokasi,
            'ontime' => $ontime,
        ]);
    }

    public function store(Request $request, $code)
    {
        $request->validate([
            'password_absen' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required',
        ], [
            'password_absen.required' => 'Password Absen Wajib Di isi',
            'latitude.required' => 'Aktifkan GPS anda',
            'longitude.required' => 'Aktifkan GPS anda',
            'image.required' => 'Wajib Selfi',

        ]);

        $now = Carbon::now();
        $tanggal = $now;
        if ($now->hour >= 0 && $now->hour < 10) {
            $tanggal = $now->subDay(1);
        }

        $lokasi = SecureLocation::where('kode_lokasi', $code)->first();

        $user = User::where('password_absen', $request->password_absen)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'security');
            })->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Password Salah Atau Anda tidak punya akses');
        }

        $cekabsen = Absensecurityceklokasi::where('securelocation_id', $lokasi->id)
            ->where('tanggal', $now->toDateString())
            ->get();

        if ($cekabsen->count() > 0) {
            return redirect()->back()->with('error', 'Lokasi Ini Sudah Melakukan Absen');
        } else {
            $isInRadius = $this->isInRadius($lokasi, $request->latitude, $request->longitude);
            $imageName = $this->storeImage($request->image);

            Absensecurityceklokasi::create([
                'tanggal' => $tanggal->toDateString(),
                'waktu_scan' => $now->format('H:i:s'),
                'securelocation_id' => $lokasi->id,
                'user_id' => $user->id,
                'in_location' => $isInRadius,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'image' => $imageName,
            ]);
            return redirect()->route('login')->with('success', 'Berhasil Melakukan Absen');
        }

    }
}
