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
use Illuminate\Support\Facades\Auth;

class AbsenMengajarPkkpsController extends Controller
{
    use SemesterAktif;
    use CekJarak;
    use PengasuhanImage;

    public function getAbsen($absen_id)
    {
        $absen = Absensekolah::findorFail($absen_id);
        $rombel = Rombel::where('id', $absen->rombel_id)->first();

        $latitude = $rombel->latitude;
        $longitude = $rombel->longitude;

        $radius = 40;

        return view('user-tailwind.absenpkkps', compact('absen', 'latitude', 'longitude', 'radius'));
    }

    public function absenPkkpsStore(Request $request, $absen_id)
    {
        $request->validate([
            'image' => 'required',
        ], [
            'image.required' => 'Foto wajib diambil',
        ]);

        $now = Carbon::now()->format('H:i:s');

        $absen = Absensekolah::findOrfail($absen_id);
        $rombel = Rombel::findOrFail($absen->rombel_id);

        // Cek Lokasi
        $is_inlocation = false;

        $latKantor = $rombel->latitude;
        $longKantor = $rombel->longitude;

        $latUser = $latKantor;
        $longUser = $longKantor;

        if ($request->lokasi) {
            $lokasi = explode(',', $request->lokasi);
            $latUser = $lokasi[0];
            $longUser = $lokasi[1];

            $jarak = $this->distance($latKantor, $longKantor, $latUser, $longUser);
            if ($jarak['meters'] <= 20) {
                $is_inlocation = true;
            };

        }
        //end Cek Lokasi

        // Save Image
        $folderPath = "public/images/";
        $fileName = $this->storeImage($request->image, $folderPath);
        // End Save Image

        $terlambat = $this->terlambat($absen->mulai_kbm, 5);

        $absen->waktu_absen = Carbon::now()->format('H:i:s');
        $absen->keterlambatan = $terlambat;
        $absen->kehadiran = 'hadir';
        $absen->in_location = $is_inlocation;
        $absen->latitude = $latUser;
        $absen->latitude = $longUser;
        $absen->image = $fileName;
        $absen->save();

        // return redirect()->route('v2.absen-siswa', $absen);

        return redirect()->route('success.page')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');

    }

    public function getRombel($rombel_id)
    {

        $user = Auth::user();

        $semester = $this->getSemesterAktif();

        $rombel = Rombel::findOrfail($rombel_id)->load('sekolah');

        $rosters = Roster::with('jammengajar')
            ->whereNotNull('user_id')
            ->where('rombel_id', $rombel_id)
            ->where('semester_id', $semester->id)
            ->whereHas('jammengajar', function ($query) {
                $query->where('hari', Carbon::now()->weekday());
            })
            ->get();

        if ($rosters->isNotEmpty()) {
            foreach ($rosters as $roster) {
                $absen = Absensekolah::firstOrNew(
                    [
                        'user_id' => $roster->user_id,
                        'tanggal' => Carbon::now()->toDateString(),
                        'jam_ke' => $roster->jammengajar->jam_ke,
                        'mulai_kbm' => $roster->jammengajar->mulai_kbm,
                        'akhir_kbm' => $roster->jammengajar->akhir_kbm,
                        'rombel_id' => $rombel_id,
                        'sekolah_id' => $rombel->sekolah_id,
                    ], [
                        'mapel_id' => $roster->mapel_id,
                        'kehadiran' => 'alpa',
                        'jumlah_jam' => $roster->jammengajar->jumlah_jam,

                    ]
                );

                $absen->save();
            }
        }

        $absen = Absensekolah::where('rombel_id', $rombel_id)
            ->where('tanggal', Carbon::now()->toDateString())
            ->where('user_id', $user->id)
            ->where('mulai_kbm', '<=', Carbon::now()->format('H:i:s'))
            ->where('akhir_kbm', '>=', Carbon::now()->format('H:i:s'))
            ->first();

        $latitude = $rombel->latitude;
        $longitude = $rombel->longitude;
        $radius = 40;

        return view('user-tailwind.absenpkkps', compact('absen', 'latitude', 'longitude', 'radius'));
    }

    public function terlambat($waktuMasuk, $toleransi)
    {

        $now = Carbon::now();
        $dispensasiWaktu = Carbon::createFromFormat('H:i:s', $waktuMasuk)->addMinutes($toleransi);

        $toleransi = $toleransi;
        $terlambat = 0;

        if ($now->greaterThan($dispensasiWaktu)) {
            $terlambat = $dispensasiWaktu->diffInMinutes($now);
        }

        return $terlambat;
    }
}
