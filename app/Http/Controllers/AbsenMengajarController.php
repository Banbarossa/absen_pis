<?php

namespace App\Http\Controllers;

use App\Models\Absensekolah;
use App\Models\Rombel;
use App\Models\Roster;
use App\Models\User;
use App\Traits\SemesterAktif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenMengajarController extends Controller
{

    use SemesterAktif;
    public function index($code)
    {

        $now = Carbon::now();
        $rombel = Rombel::where('kode_rombel', $code)->first();
        $countAbsen = Absensekolah::where('tanggal', $now->toDateString())->where('rombel_id', $rombel->id)->get();
        if ($countAbsen->count() === 0) {
            $rosterToday = Roster::with('jammengajar', 'rombel')
                ->where('semester_id', $this->getSemesterAktif()->id)
                ->where('rombel_id', $rombel->id)
                ->whereNotNull('user_id')
                ->whereHas('jammengajar', function ($query) use ($now) {
                    $query->where('hari', $now->dayOfWeek);
                })->get();

            foreach ($rosterToday as $roster) {
                Absensekolah::create([
                    'user_id' => $roster->user_id,
                    'tanggal' => $now->toDateString(),
                    'jam_ke' => $roster->jammengajar->jam_ke,
                    'mulai_kbm' => $roster->jammengajar->mulai_kbm,
                    'akhir_kbm' => $roster->jammengajar->akhir_kbm,
                    'rombel_id' => $roster->rombel_id,
                    'sekolah_id' => $roster->rombel->sekolah_id,
                    'mapel_id' => $roster->mapel_id,
                    'jumlah_jam' => $roster->jammengajar->jumlah_jam,
                    'kehadiran' => 'alpa',
                ]);
            }
            // $data = 'Data Absen Berhasil di generate';

            // Mail::to('banbarossa@gmail.com')->send(new CreateUpdateAbsen($data));

        }

        $absen = Absensekolah::with('user', 'mapel', 'rombel')->where('tanggal', $now->toDateString())
            ->where('rombel_id', $rombel->id)
            ->where('mulai_kbm', '<=', $now->addMinutes(10)->format('H:i:s'))->where('akhir_kbm', '>=', $now->addMinutes(15)->format('H:i:s'))
            ->first();

        return view('guest.absen-mengajar', [
            'id_rombel' => $code,
            'absen' => $absen,
        ]);

    }

    public function store(Request $request, $id)
    {
        // validasi
        $request->validate([
            'image' => 'required',
            'password_absen' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
            'password_absen.required' => 'Password Absen Wajib Diisi',
        ]);

        // pengecekan password
        $absenSekolah = Absensekolah::find($id);
        $user = User::find($absenSekolah->user_id);
        if ($user->password_absen != $request->password_absen) {
            return redirect()->back()->with('error', 'Password Tidak Tepat');
        }

        // Perhitungan keterlambatan
        $now = Carbon::now();
        $waktuDispensasi = intval(env('MENIT_DISPENSASI', 10));
        $dispensasiTime = Carbon::parse($absenSekolah->mulai_kbm)->addMinutes($waktuDispensasi);

        $keterlambatan = 0;
        if ($now > $dispensasiTime) {
            $keterlambatan = $keterlambatanInterval = $now->diff($dispensasiTime);
            $keterlambatan = $keterlambatanInterval->h * 60 + $keterlambatanInterval->i + $keterlambatanInterval->s / 60;
        }

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

        // store to data base
        $absenSekolah->update([
            'waktu_absen' => $now->format('H:i:s'),
            'kehadiran' => 'hadir',
            'keterlambatan' => $keterlambatan,
            'image' => $fileName,
            'in_location' => $isInRadius,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

        ]);

        return redirect()->route('login')->with('success', 'Terima Kasih Anda telah Melakukan Absen. untuk melihat transaksi Absen silahkan Login');
    }
}
