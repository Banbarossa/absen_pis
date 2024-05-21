<?php

namespace App\Http\Controllers;

use App\Models\Absenhalaqah;
use App\Models\JadwalHalaqah;
use App\Models\User;
use App\Traits\CekJarak;
use App\Traits\PengasuhanImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestAbsenHalaqahController extends Controller
{

    use PengasuhanImage;
    use CekJarak;
    public function index()
    {

        $userWithAksesHalaqah = User::role('musyrif halaqah')->get();

        $now = Carbon::now();

        $jadwalHalaqah = JadwalHalaqah::where('nama_sesi', '!=', 'khusus')->where('hari', $now->dayOfWeek)
            ->where('is_aktif', 1)
            ->where('mulai_absen', '<=', Carbon::parse($now)->format('H:i:s'))
            ->where('akhir_absen', '>=', Carbon::parse($now)->format('H:i:s'))
            ->first();

        if (!$jadwalHalaqah) {
            $jadwal = '';
            return view('halaman-error', [
                'judul' => 'Tidak ditemukan Jadwal',
                'content' => 'Tidak ditemukan jadwal yang valid, silahkan hubungi admin',
            ]);
        }

        $absen_today = Absenhalaqah::where('tanggal', $now->toDateString())
            ->where('jadwal_halaqah_id', $jadwalHalaqah->id)
            ->get();

        if ($absen_today->count() === 0) {
            $jadwalHalaqah = JadwalHalaqah::where('hari', $now->dayOfWeek)->where('nama_sesi', '!=', 'khusus')->where('is_aktif', 1)->get();

            foreach ($jadwalHalaqah as $jadwal) {
                foreach ($userWithAksesHalaqah as $user) {
                    Absenhalaqah::firstOrCreate([
                        "jadwal_halaqah_id" => $jadwal->id,
                        "user_id" => $user->id,
                        "tanggal" => $now->toDateString(),
                        "kehadiran" => 'alpa',
                    ]);
                }

            }
        }

        return view('guest.absen-halaqah', [
            'title' => 'Absen Halaqah',
            'jadwal' => $jadwalHalaqah,
            'latitude' => 5.463451583675343,
            'longitude' => 95.3861015036581,
            'radius' => 30,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'password_absen' => 'required',
            // 'lokasi' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
            'password_absen.required' => 'Password Absen Wajib Diisi',
            // 'lokasi.required' => 'Gunakan Browser yang support Geo Location Seperti Chrome dan Mozilla. dan berikan akses menggunakan lokasi',

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

            // Simpan Image
            $folderPath = "public/images/";
            $fileName = $this->storeImage($request->image, $folderPath);

            //hitung radius

            $latmesjid = 5.463451583675343;
            $lonmesjid = 95.3861015036581;

            $lokasiuser = explode(',', $request->lokasi);

            $jarak = $this->distance($latmesjid, $lonmesjid, $lokasiuser[0], $lokasiuser[1]);

            $isInRadius = true;

            if ($jarak['meters'] > 20) {

                $isInRadius = false;
                // return redirect()->back()->with('error', 'Maaf Anda Berada diluar Radius');
            };

            // Update Data absen
            $absen->update([
                'waktu_absen' => $now->format('H:i:s'),
                'kehadiran' => 'hadir',
                'image' => $fileName,
                'in_location' => $isInRadius,
                'latitude' => $lokasiuser[0],
                'longitude' => $lokasiuser[1],
            ]);

            return redirect()->route('success.page')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');
        }

    }

    public function khusus()
    {
        return view('guest.absen-halaqah-khusus', [
            'title' => 'Absen Halaqah Khusus',
            'latitude' => 5.463451583675343,
            'longitude' => 95.3861015036581,
            'radius' => 30,
        ]);

    }
    public function storeKhusus(Request $request)
    {

        $request->validate([
            'image' => 'required',
            'password_absen' => 'required',
            // 'lokasi' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
            'password_absen.required' => 'Password Absen Wajib Diisi',
            // 'lokasi.required' => 'Silahkan Menggunakan Browser Yang mendukung Geolocation, dan memberikan izin akses',
        ]);

        $user = User::where('password_absen', $request->password_absen)->role('musyrif halaqah')->first();
        $now = Carbon::now();

        if ($user) {

            $folderPath = "public/images/";
            $fileName = $this->storeImage($request->image, $folderPath);

            //hitung radius

            $latmesjid = 5.463451583675343;
            $lonmesjid = 95.3861015036581;

            $lokasiuser = explode(',', $request->lokasi);

            $jarak = $this->distance($latmesjid, $lonmesjid, $lokasiuser[0], $lokasiuser[1]);

            $isInRadius = true;

            if ($jarak['meters'] > 20) {

                $isInRadius = false;
                // return redirect()->back()->with('error', 'Maaf Anda Berada diluar Radius');
            };

            $jadwal = JadwalHalaqah::where('nama_sesi', 'khusus')->first();

            Absenhalaqah::create([

                "jadwal_halaqah_id" => $jadwal->id,
                "user_id" => $user->id,
                "tanggal" => $now->toDateString(),
                "kehadiran" => 'hadir',
                'waktu_absen' => $now->format('H:i:s'),
                'in_location' => $isInRadius,
                'latitude' => $lokasiuser[0],
                'longitude' => $lokasiuser[1],
                'image' => $fileName,
            ]);
        }

        return redirect()->route('success.page')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');

    }
}
