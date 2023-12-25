<?php

namespace App\Http\Controllers;

use App\Models\Absenkaryawan;
use App\Models\Jamkaryawan;
use App\Models\User;
use App\Traits\PengasuhanImage;
use App\Traits\PengasuhanLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestAbsenKaryawan extends Controller
{
    use PengasuhanLocation;
    use PengasuhanImage;
    public function index()
    {
        $now = Carbon::now()->format('H:i');

        $jam_karyawan = Jamkaryawan::whereHas('roles', function ($query) {
            $query->where('name', 'musyrif asrama');
        })
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->where('mulai_absen_masuk', '<=', $now)
                        ->where('akhir_absen_masuk', '>=', $now);
                })
                    ->orWhere(function ($q) use ($now) {
                        $q->where('mulai_absen_pulang', '<=', $now)
                            ->where('akhir_absen_pulang', '>=', $now);
                    });
            })
            ->first();

        if ($jam_karyawan) {
            if ($jam_karyawan->mulai_absen_masuk <= $now && $jam_karyawan->akhir_absen_masuk >= $now) {
                $type = 'masuk';
            } elseif ($jam_karyawan->mulai_absen_pulang <= $now && $jam_karyawan->akhir_absen_pulang >= $now) {
                $type = 'pulang';
            }
        } else {
            $type = 'non_absen';
        }

        return view('guest.absen-karyawan', [
            'jam_karyawan' => $jam_karyawan,
            'type' => $type,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'password_absen' => 'required',
        ]);
        $user_id = User::where('password_absen', $request->password_absen)->first()->id;
        if (!$user_id) {
            return redirect()->back()->with('error', 'Password Salah, Atau Anda Tidak Punya Akses');
        }

        $jam = Jamkaryawan::find($request->jamkaryawan_id);

        $now = Carbon::now();

        $tanggal = $now;

        if ($now->hour >= 0 && $now->hour < 10) {
            $tanggal = $now->subDay(1);
        }

        $isInRadius = $this->pengasuhanRadius($request->latitude, $request->longitude);

        $type = $request->type;

        if ($type == 'non_absen') {

            return redirect()->back()->with('error', 'Tidak Ada Jadwal Yang cocok saat ini');

        } elseif ($type == 'masuk') {
            $imageName = '';
            if ($request->image) {
                $imageName = $this->storeImage($request->image);

            }

            Absenkaryawan::create([
                'user_id' => $user_id,
                'jamkaryawan_id' => $jam,
                'tanggal' => $tanggal->toDateString(),
                'jam_masuk' => $jam->jam_masuk,
                'jam_pulang' => $jam->jam_pulang,
                'scan_masuk' => $now->format('H:i:s'),
                'terlambat' => '',
                'masuk_in_location' => $isInRadius,
                'masuk_latitude' => $request->latitude,
                'masuk_longitude' => $request->longitude,
                'masuk_image' => $imageName,
            ]);

        } else {

            $imageName = '';
            if ($request->image) {
                $imageName = $this->storeImage($request->image);

            }

            Absenkaryawan::updateOrCreate([
                'user_id' => $user_id,
                'jamkaryawan_id' => $jam,
                'tanggal' => $tanggal->toDateString(),
                'jam_masuk' => $jam->jam_masuk,
                'jam_pulang' => $jam->jam_pulang,
            ], [
                'scan_pulang' => $now->format('H:i:s'),
                'selisih_waktu' => 0,
                'pulang_in_location' => $isInRadius,
                'pulang_latitude' => $request->latitude,
                'pulang_longitude' => $request->longitude,
                'pulang_image' => $imageName,

            ]);

        }

    }
}
