<?php

namespace App\Http\Controllers;

use App\Models\Absenhalaqah;
use App\Models\JadwalHalaqah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestAbsenHalaqahController extends Controller
{
    public function index()
    {

        $userWithAksesHalaqah = User::role('musyrif halaqah')->get();

        $now = Carbon::now();

        // $kejam = Carbon::parse($now)->format("H:i:s");
        // dd($kejam);

        $urutanHariDalamPekan = $now->isoWeekday();

        $jadwalHalaqah = JadwalHalaqah::where('nama_sesi', '!=', 'khusus')->where('hari', $now->dayOfWeek)
            ->where('mulai_absen', '<=', Carbon::parse($now)->format('H:i:s'))
            ->where('akhir_absen', '>=', Carbon::parse($now)->format('H:i:s'))
            ->first();

        if (!$jadwalHalaqah) {
            $jadwal = '';
            return view('guest.absen-halaqah', [
                'jadwal' => $jadwal,
            ]);
        }

        $absen_today = Absenhalaqah::where('tanggal', $now->toDateString())
            ->where('jadwal_halaqah_id', $jadwalHalaqah->id)
            ->get();

        // if ($absen_today->count() === 0) {
        $jadwalHalaqah = JadwalHalaqah::where('hari', $now->dayOfWeek)->get();

        foreach ($jadwalHalaqah as $jadwal) {
            foreach ($userWithAksesHalaqah as $user) {
                Absenhalaqah::firstOrCreate([
                    "jadwal_halaqah_id" => $jadwal->id,
                    "user_id" => $user->id,
                    "tanggal" => $now->toDateString(),
                ], [
                    "kehadiran" => 'alpa',
                ]);
            }
        }

        // foreach ($jadwalHalaqah as $jadwal) {
        //     foreach ($userWithAksesHalaqah as $user) {
        //         Absenhalaqah::firstOrCreate([
        //             "jadwal_halaqah_id" => $jadwal->id,
        //             "user_id" => $user->id,
        //             "tanggal" => $now->toDateString(),
        //             "kehadiran" => 'alpa',
        //         ]);
        //     }

        // }
        // }

        $jadwal = JadwalHalaqah::where('hari', $urutanHariDalamPekan)
            ->where('mulai_absen', '<=', $now->format('H:i:s'))
            ->where('akhir_absen', '>=', $now->format('H:i:s'))
            ->first();

        return view('guest.absen-halaqah', [
            // 'absen' => $absen,
            'jadwal' => $jadwal,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'password_absen' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
            'password_absen.required' => 'Password Absen Wajib Diisi',
        ]);
        $now = Carbon::now();
        $user = User::where('password_absen', $request->password_absen)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Password Anda Salah');
        }

        $absen = Absenhalaqah::with('user')->whereHas('jadwalhalaqah', function ($query) use ($now) {
            $query->where('mulai_absen', '<=', $now->format('H:i:s'))->where('akhir_absen', '>=', $now->format('H:i:s'));
        })
            ->where('user_id', $user->id)
            ->where('tanggal', $now->toDateString())
            ->first();

        if (!$absen) {
            return redirect()->back()->with('error', 'Data Absen tidak ditemukan');
        } else {
            // simpan image
            $img = $request->image;
            $folderPath = "public/images/";

            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';

            $file = $folderPath . $fileName;
            Storage::put($file, $image_base64);

            //hitung radius
            $allowedLatitude = 5.463151;
            $allowedLongitude = 95.386354;
            $maxDistance = 1000;

            $earthRadius = 6371; // Radius Bumi dalam kilometer
            $dLat = deg2rad($allowedLatitude - $request->latitude);
            $dLon = deg2rad($allowedLongitude - $request->longitude);
            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($request->latitude)) * cos(deg2rad($allowedLatitude)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c * $maxDistance; // Jarak dalam meter

            if ($distance <= $maxDistance) {
                $isInRadius = true;
            } else {
                $isInRadius = false;
            }

            // Update Data absen
            $absen->update([
                'waktu_absen' => $now->format('H:i:s'),
                'kehadiran' => 'hadir',
                'image' => $fileName,
                'in_location' => $isInRadius,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return redirect()->route('login')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');
        }

    }

    public function khusus()
    {
        return view('guest.absen-halaqah-khusus');

    }
    public function storeKhusus(Request $request)
    {

        $request->validate([
            'image' => 'required',
            'password_absen' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
            'password_absen.required' => 'Password Absen Wajib Diisi',
        ]);

        $user = User::where('password_absen', $request->password_absen)->role('musyrif halaqah')->first();
        $now = Carbon::now();

        if ($user) {
            $img = $request->image;
            $folderPath = "public/images/";

            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';

            $file = $folderPath . $fileName;
            Storage::put($file, $image_base64);

            //hitung radius
            $allowedLatitude = 5.463151;
            $allowedLongitude = 95.386354;
            $maxDistance = 1000;

            $earthRadius = 6371; // Radius Bumi dalam kilometer
            $dLat = deg2rad($allowedLatitude - $request->latitude);
            $dLon = deg2rad($allowedLongitude - $request->longitude);
            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($request->latitude)) * cos(deg2rad($allowedLatitude)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c * $maxDistance; // Jarak dalam meter

            if ($distance <= $maxDistance) {
                $isInRadius = true;
            } else {
                $isInRadius = false;
            }

            $jadwal = JadwalHalaqah::where('nama_sesi', 'khusus')->first();

            Absenhalaqah::create([

                "jadwal_halaqah_id" => $jadwal->id,
                "user_id" => $user->id,
                "tanggal" => $now->toDateString(),
                "kehadiran" => 'hadir',
                'waktu_absen' => $now->format('H:i:s'),
                'in_location' => $isInRadius,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'image' => $fileName,
            ]);
        }

        return redirect()->route('login')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');

    }
}
