<?php

namespace App\Http\Controllers;

use App\Models\Absendinasluar;
use App\Models\Absenkaryawan;
use App\Models\Absenkaryawandetail;
use App\Models\Bagianuser;
use App\Models\Jamkaryawan;
use App\Models\User;
use App\Traits\CekJarak;
use App\Traits\PengasuhanImage;
use App\Traits\PengasuhanLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestAbsenKaryawan extends Controller
{
    use PengasuhanLocation;
    use PengasuhanImage;
    use CekJarak;

    public function index($name)
    {
        $now = Carbon::now()->format('H:i');
        $bagianuser = Bagianuser::where('name', $name)->first();

        if (!$bagianuser) {
            return abort(404);
        }

        $lokasi = explode(',', $bagianuser->lokasi);
        $latitude = $lokasi[0];
        $longitude = $lokasi[1];

        if ($this->isSunday()) {
            return view('halaman-error', [
                'judul' => 'Hari Ahad',
                'content' => 'Tidak Ada Jadwal Pada Hari ini',
            ]);
        };

        $absen_masuk_1 = Jamkaryawan::selectRaw('*, "masuk_1" as absen_type')
            ->where('bagianuser_id', $bagianuser->id)
            ->where('mulai_absen_masuk_1', '<=', $now)
            ->where('akhir_absen_masuk_1', '>=', $now);

        $absen_masuk_2 = Jamkaryawan::selectRaw('*, "masuk_2" as absen_type')
            ->where('bagianuser_id', $bagianuser->id)
            ->where('mulai_absen_masuk_2', '<=', $now)
            ->where('akhir_absen_masuk_2', '>=', $now);

        $absen_pulang = Jamkaryawan::selectRaw('*, "pulang" as absen_type')
            ->where('bagianuser_id', $bagianuser->id)
            ->where('mulai_absen_pulang', '<=', $now)
            ->where('akhir_absen_pulang', '>=', $now);

        $jam_karyawan = $absen_masuk_1->union($absen_masuk_2)->union($absen_pulang)->first();
        if ($jam_karyawan) {
            $absen_type = $jam_karyawan->absen_type;
        } else {
            $absen_type = null;
            return view('halaman-error', [
                'judul' => 'Tidak ditemukan Jadwal',
                'content' => 'Tidak ditemukan jadwal yang valid, silahkan hubungi admin',
            ]);

        }

        $now = Carbon::now();
        $title = 'ABSEN PEGAWAI';
        $radius = $bagianuser->radius;
        return view('guest.tailwind.absen-karyawan', compact('name', 'radius', 'title', 'jam_karyawan', 'now', 'absen_type', 'bagianuser', 'latitude', 'longitude'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'password_absen' => 'required',
            'jamkaryawan_id' => 'required|numeric',
            'absen_type' => 'required',
            'bagianuser_id' => 'required|numeric',
            'image' => 'required',
            // 'lokasi' => 'required',
        ]);

        $latKantor = 5.463230;
        $longKantor = 95.386380;

        // cekLokasi

        $is_inlocation = false;

        $lokasi = $latKantor . ',' . $longKantor;
        $latUser = 5.463230;
        $longUser = 95.386380;

        if ($request->lokasi) {
            $lokasi = explode(',', $request->lokasi);
            $latUser = $lokasi[0];
            $longUser = $lokasi[1];

            $jarak = $this->distance($latKantor, $longKantor, $latUser, $longUser);
            if ($jarak['meters'] <= 20) {
                $is_inlocation = true;
                // return redirect()->back()->with('error', 'Maaf Anda Berada diluar Radius');
            };

        }

        $jamKaryawan = Jamkaryawan::findOrFail($request->jamkaryawan_id);
        $now = Carbon::now();

        if ($request->absen_type == 'pulang' && $jamKaryawan->ischeckouttomorrow) {
            $now = Carbon::now()->subDays(1);
        }

        // Cek User
        $user = User::where('password_absen', $request->password_absen)
            ->where('is_karyawan', true)
            ->where('status', true)
            ->where('bagianuser_id', $request->bagianuser_id)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Password Salah, Atau Anda Tidak Punya Akses');
        }

        // Cek Terlambat Atau Pulang Cepat
        $getSelisih = $this->selisihWaktu($jamKaryawan, $request->absen_type);

        $absen = Absenkaryawan::firstOrNew([
            'user_id' => $user->id,
            'tanggal' => $now->toDateString(),
            'jamkaryawan_id' => $request->jamkaryawan_id,
            'bagianuser_id' => $request->bagianuser_id,
        ]);

        $absen->save();

        if ($request->image) {
            $folderPath = "public/images/karyawan/";
            $imageName = $this->storeImage($request->image, $folderPath);
        }

        $existingDetail = Absenkaryawandetail::where('absenkaryawan_id', $absen->id)
            ->where('type', $request->absen_type)
            ->first();

        if ($existingDetail) {
            return redirect()->route('login')->with('error', 'Anda sudah melakukan absen sebelumnya.');
        }

        Absenkaryawandetail::create(
            [
                'absenkaryawan_id' => $absen->id,
                'type' => $request->absen_type,
                'jam' => Carbon::now()->format('H:i:s'),
                'selisih_waktu' => $getSelisih,
                'lokasi' => $latUser . "," . $longUser,
                'image' => $imageName,

            ]);

        return redirect()->route('success.page')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');

    }

    public function absendinasluar()
    {

        $now = Carbon::now()->format('H:i');

        $user = Auth::user();
        $bagianuser = Bagianuser::findOrFail($user->bagianuser_id);

        if (!$bagianuser) {
            return abort(404);
        }

        $lokasi = explode(',', $bagianuser->lokasi);
        $latitude = $lokasi[0];
        $longitude = $lokasi[1];

        if ($this->isSunday()) {
            return view('halaman-error', [
                'judul' => 'Hari Ahad',
                'content' => 'Tidak Ada Jadwal Pada Hari ini',
            ]);
        };

        $absen_masuk_1 = Jamkaryawan::selectRaw('*, "masuk_1" as absen_type')
            ->where('bagianuser_id', $bagianuser->id)
            ->where('mulai_absen_masuk_1', '<=', $now)
            ->where('akhir_absen_masuk_1', '>=', $now);

        $absen_masuk_2 = Jamkaryawan::selectRaw('*, "masuk_2" as absen_type')
            ->where('bagianuser_id', $bagianuser->id)
            ->where('mulai_absen_masuk_2', '<=', $now)
            ->where('akhir_absen_masuk_2', '>=', $now);

        $absen_pulang = Jamkaryawan::selectRaw('*, "pulang" as absen_type')
            ->where('bagianuser_id', $bagianuser->id)
            ->where('mulai_absen_pulang', '<=', $now)
            ->where('akhir_absen_pulang', '>=', $now);

        $jam_karyawan = $absen_masuk_1->union($absen_masuk_2)->union($absen_pulang)->first();
        if ($jam_karyawan) {
            $absen_type = $jam_karyawan->absen_type;
        } else {
            $absen_type = null;
            return view('halaman-error', [
                'judul' => 'Tidak ditemukan Jadwal',
                'content' => 'Tidak ditemukan jadwal yang valid, silahkan hubungi admin',
            ]);

        }

        $existingDetail = Absenkaryawandetail::where('type', $absen_type)
            ->whereHas('absenkaryawan', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->first();

        if ($existingDetail) {
            return view('halaman-error', [
                'judul' => 'Sudah Absen',
                'content' => 'Sebelumnya anda sudah melakukan absen, Silahkan lanjutkan aktifitas anda',
            ]);
        }

        $now = Carbon::now();
        $title = 'ABSEN PEGAWAI';
        $radius = $bagianuser->radius;
        return view('guest.tailwind.absen-dinasluar', compact('radius', 'title', 'jam_karyawan', 'now', 'absen_type', 'latitude', 'longitude'));
    }

    public function storeDinasluar(Request $request, $type)
    {

        $request->validate([
            'jamkaryawan_id' => 'required|numeric',
            'image' => 'required',
            'keterangan' => 'required',
        ]);

        $latKantor = 5.463230;
        $longKantor = 95.386380;

        // cekLokasi

        $is_inlocation = false;

        if ($request->lokasi) {
            $lokasi = explode(',', $request->lokasi);
            $latUser = $lokasi[0];
            $longUser = $lokasi[1];

            $jarak = $this->distance($latKantor, $longKantor, $latUser, $longUser);
            if ($jarak['meters'] <= 20) {
                $is_inlocation = true;
                // return redirect()->back()->with('error', 'Maaf Anda Berada diluar Radius');
            };

        }

        $jamKaryawan = Jamkaryawan::findOrFail($request->jamkaryawan_id);
        $now = Carbon::now();

        if ($request->absen_type == 'pulang' && $jamKaryawan->ischeckouttomorrow) {
            $now = Carbon::now()->subDays(1);
        }

        // Cek User

        $login = Auth::user();
        $user = User::where('id', $login->id)
            ->where('is_karyawan', true)
            ->where('status', true)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Anda Tidak Punya Akses');
        }

        $bagianuser = Bagianuser::findOrFail($user->bagianuser_id);

        // Cek Terlambat Atau Pulang Cepat
        $getSelisih = $this->selisihWaktu($jamKaryawan, $request->absen_type);

        $absen = Absenkaryawan::firstOrNew([
            'user_id' => $user->id,
            'tanggal' => $now->toDateString(),
            'jamkaryawan_id' => $request->jamkaryawan_id,
            'bagianuser_id' => $bagianuser->id,
        ]);

        $absen->save();

        if ($request->image) {
            $folderPath = "public/images/karyawan/";
            $imageName = $this->storeImage($request->image, $folderPath);
        }

        $existingDetail = Absenkaryawandetail::where('absenkaryawan_id', $absen->id)
            ->where('type', $type)
            ->first();

        if ($existingDetail) {
            return redirect()->route('login')->with('error', 'Anda sudah melakukan absen sebelumnya.');
        }

        $detail = new Absenkaryawandetail();
        $detail->absenkaryawan_id = $absen->id;
        $detail->type = $type;
        $detail->jam = Carbon::now()->format('H:i:s');
        $detail->selisih_waktu = $getSelisih;
        $detail->lokasi = $request->lokasi;
        $detail->image = $imageName;

        $detail->save();

        $absendinasluar = new Absendinasluar();
        $absendinasluar->absenkaryawandetail_id = $detail->id;
        $absendinasluar->keterangan = $request->keterangan;
        $absendinasluar->save();

        return redirect()->route('success.page')->with('success', 'Berhasil Melakukan Absen, Jazakumullahukhairan');

    }

    public function isSunday()
    {
        $is_sunday = Carbon::now()->isSunday();
        return $is_sunday;
    }

    public function selisihWaktu($jamKaryawan, $typeAbsen)
    {
        $now = Carbon::now();
        $toleransi = $jamKaryawan->toleransi;
        $selisih_waktu = 0;
        $getSelisih = 0;

        if ($typeAbsen == 'masuk_1') {

            $waktuAbsen = Carbon::parse($jamKaryawan->jam_masuk_1);

            if ($now > $waktuAbsen) {
                $selisih_waktu = $waktuAbsen->diffInMinutes($now);
            }
            $getSelisih = $selisih_waktu > $toleransi ? $selisih_waktu : 0;

        } elseif ($typeAbsen == 'masuk_2') {
            $waktuAbsen = Carbon::parse($jamKaryawan->jam_masuk_2);
            if ($now > $waktuAbsen) {
                $selisih_waktu = $waktuAbsen->diffInMinutes($now);
            }
            $getSelisih = $selisih_waktu > $toleransi ? $selisih_waktu : 0;

        } else {
            $waktuAbsen = Carbon::parse($jamKaryawan->jam_pulang);
            if ($now < $waktuAbsen) {
                $selisih_waktu = $now->diffInMinutes($waktuAbsen);
            }
            $getSelisih = $selisih_waktu;
        }
        return $getSelisih;
    }

}
