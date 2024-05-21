<?php

namespace App\Http\Controllers;

use App\Models\Absensekolah;
use App\Models\Rombel;
use App\Models\Roster;
use App\Models\User;
use App\Traits\CekJarak;
use App\Traits\PengasuhanImage;
use App\Traits\SemesterAktif;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenMengajarController extends Controller
{

    use SemesterAktif;
    use PengasuhanImage;
    use CekJarak;
    public function index($code)
    {

        $now = Carbon::now();
        $rombel = Rombel::where('kode_rombel', $code)->first();
        if (!$rombel->can_absen) {
            return view('halaman-error', [
                'judul' => 'Tidak Memiliki Access',
                'content' => 'Kelas ini tidak memiliki akses absen, silahkan hubungi admin',
            ]);
        }

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
            ->where('mulai_kbm', '<=', $now->addMinutes(10)->format('H:i:s'))->where('akhir_kbm', '>=', $now->addMinutes(12)->format('H:i:s'))
            ->first();

        return view('guest.absen-mengajar', [
            'title' => 'Absen Mengajar',
            'id_rombel' => $code,
            'absen' => $absen,
            'latitude' => 5.4630899676613875,
            'longitude' => 95.38699315801608,
            'radius' => 40,
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

        $keterlambatan = $this->terlambat($absenSekolah->mulai_kbm, 10, );

        //hitung radius
        $latSekolah = 5.4630899676613875;
        $lonsekolah = 95.38699315801608;

        $lokasiuser = explode(',', $request->lokasi);

        $isInRadius = true;
        $jarak = $this->distance($latSekolah, $lonsekolah, $lokasiuser[0], $lokasiuser[1]);

        if ($jarak['meters'] > 40) {

            $isInRadius = false;
            // return redirect()->back()->with('error', 'Maaf Anda Berada diluar Radius');
        };

        // simpan image

        $folderPath = "public/images/";
        $fileName = $this->storeImage($request->image, $folderPath);

        // store to data base
        $absenSekolah->update([
            'waktu_absen' => Carbon::now()->format('H:i:s'),
            'kehadiran' => 'hadir',
            'keterlambatan' => $keterlambatan,
            'image' => $fileName,
            'in_location' => $isInRadius,
            'latitude' => $lokasiuser[0],
            'longitude' => $lokasiuser[0],

        ]);

        return redirect()->route('success.page')->with('success', 'Terima Kasih Anda telah Melakukan Absen. Silahkan Lanjutkan Aktifitas Anda');
    }

    public function terlambat($waktuMasuk, $toleransi)
    {

        $now = Carbon::now();
        $dispensasiWaktu = Carbon::parse($waktuMasuk)->addMinutes($toleransi);
        $toleransi = $toleransi;
        $terlambat = 0;

        if ($now > $dispensasiWaktu) {
            $terlambat = $dispensasiWaktu->diffInMinutes($now);
        }
        return $terlambat;
    }
}
