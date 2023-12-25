<?php

namespace App\Http\Controllers;

use App\Models\Absenalternatif;
use App\Models\Rombel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenAlternatifController extends Controller
{
    public function index($code)
    {
        return view('guest.absen-alternatif', [
            'id_rombel' => $code,
        ]);

    }

    public function store(Request $request, $code)
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
            Absenalternatif::create([
                'user_id' => $user->id,
                'rombel_id' => $rombel->id,
                'tanggal' => $now->toDateString(),
                'waktu_absen' => $now->format('H:i:s'),
                'jumlah_jam' => 2,
                'image' => $fileName,
                'alasan' => $request->alasan,
            ]);

        }
        return redirect()->route('login')->with('success', 'Terima Kasih Anda telah Melakukan Absen. untuk melihat transaksi Absen silahkan Login');
    }
}
