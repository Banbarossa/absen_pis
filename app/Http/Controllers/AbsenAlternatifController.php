<?php

namespace App\Http\Controllers;

use App\Models\Absenalternatif;
use App\Models\Absensekolah;
use App\Models\Rombel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenAlternatifController extends Controller
{
    public function alternatifIndex($code)
    {
        return view('guest.absen-alternatif', [
            'id_rombel' => $code,
        ]);
    }

    public function alternatifStore(Request $request, $code)
    {
        $rombel = Rombel::where('kode_rombel', $code)->first();
        if (!$rombel) {
            return redirect()->back()->with('error', 'Rombel tidak ditemukan');
        }

        $request->validate([
            'image' => 'required',
            'alasan' => 'required|min:10',
            'password_absen' => 'required',
            'jumlah_jam' => 'required|numeric|digits:1',
        ], [
            'image.required' => 'Foto wajib diambil',
            'alasan.required' => 'Alasan wajib diisi',
            'alasan.min' => 'Alasan minimal 10 karakter',
            'password_absen.required' => 'Password Absen Wajib Diisi',
        ]);

        $user = User::role('guru')->where('password_absen', $request->password_absen)->first();
        if ($user) {

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

            //ambil waktu sekarang
            $now = Carbon::now();

            //simpan data ke model
            $alternatif = new Absenalternatif();
            $alternatif->user_id = $user->id;
            $alternatif->rombel_id = $rombel->id;
            $alternatif->tanggal = $now->toDateString();
            $alternatif->waktu_absen = $now->format('H:i:s');
            $alternatif->jumlah_jam = $request->jumlah_jam;
            $alternatif->image = $fileName;
            $alternatif->alasan = $request->alasan;
            $alternatif->save();

        }
        return redirect()->route('login')->with('success', 'Terima Kasih Anda telah Melakukan Absen. untuk melihat transaksi Absen silahkan Login');
    }
    public function penggantiIndex($code)
    {

        $now = Carbon::now();
        $rombel = Rombel::where('kode_rombel', $code)->first();
        $absen = Absensekolah::with('user', 'mapel', 'rombel')->where('tanggal', $now->toDateString())
            ->where('rombel_id', $rombel->id)
            ->where('mulai_kbm', '<=', $now->addMinutes(10)->format('H:i:s'))->where('akhir_kbm', '>=', $now->addMinutes(15)->format('H:i:s'))
            ->first();

        return view('guest.absen-pengganti', [
            'id_rombel' => $code,
            'absen' => $absen,
        ]);

    }

    public function penggantiStore(Request $request, $code)
    {
        $rombel = Rombel::where('kode_rombel', $code)->first();
        if (!$rombel) {
            return redirect()->back()->with('error', 'Rombel tidak ditemukan');
        }

        $request->validate([
            'image' => 'required',
            'alasan' => 'required|min:10',
            'password_absen' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
            'alasan.required' => 'Alasan wajib diisi',
            'alasan.min' => 'Alasan minimal 10 karakter',
            'password_absen.required' => 'Password Absen Wajib Diisi',
        ]);

        // pengecekan password
        $absenSekolah = Absensekolah::find($request->absen_id);

        $user = User::role('guru')->where('password_absen', $request->password_absen)->first();
        if ($user) {

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

            //ambil waktu sekarang
            $now = Carbon::now();

            // Perhitungan keterlambatan
            $waktuDispensasi = intval(env('MENIT_DISPENSASI', 10));
            $dispensasiTime = Carbon::parse($absenSekolah->mulai_kbm)->addMinutes($waktuDispensasi);

            $keterlambatan = 0;
            if ($now > $dispensasiTime) {
                $keterlambatan = $keterlambatanInterval = $now->diff($dispensasiTime);
                $keterlambatan = $keterlambatanInterval->h * 60 + $keterlambatanInterval->i + $keterlambatanInterval->s / 60;
            }

            //simpan data ke model
            $alternatif = new Absenalternatif();
            $alternatif->user_id = $user->id;
            $alternatif->rombel_id = $rombel->id;
            $alternatif->tanggal = $now->toDateString();
            $alternatif->waktu_absen = $now->format('H:i:s');
            $alternatif->jumlah_jam = 2;
            $alternatif->image = $fileName;
            $alternatif->alasan = $request->alasan;
            $alternatif->save();

            $absenSekolah->update([
                "user_id" => $user->id,
                "kehadiran" => "hadir",
                "waktu_absen" => $now->format('H:i:s'),
                'keterlambatan' => $keterlambatan,
                'image' => $fileName,
                'absenalternatif_id' => $alternatif->id,
            ]);

        }
        return redirect()->route('login')->with('success', 'Terima Kasih Anda telah Melakukan Absen. untuk melihat transaksi Absen silahkan Login');
    }
}
