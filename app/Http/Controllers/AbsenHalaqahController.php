<?php

namespace App\Http\Controllers;

use App\Models\Absenhalaqah;
use App\Models\Absensekolah;
use App\Models\JadwalHalaqah;
use App\Models\Roster;
use App\Models\Sekolah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsenHalaqahController extends Controller
{

    public function generateAbsen()
    {

        $userWithAksesHalaqah = User::role('musyrif halaqah')->get();

        $today = Carbon::now();

        $jadwalHalaqah = JadwalHalaqah::where('hari', $today->dayOfWeek)->get();

        foreach ($jadwalHalaqah as $jadwal) {
            foreach ($userWithAksesHalaqah as $user) {
                Absenhalaqah::firstOrCreate([
                    "jadwal_halaqah_id" => $jadwal->id,
                    "user_id" => $user->id,
                    "tanggal" => $today->toDateString(),
                ]);
            }

        }

        return redirect('admin/absen-halaqah');

    }

    public function userAbsen()
    {
        $user = Auth::user();
        $today = Carbon::now();
        $now = $today->format('H:i:s');

        $getDataAbsen = Absenhalaqah::where('user_id', $user->id)
            ->where('tanggal', $today->toDateString())
            ->whereHas('jadwalhalaqah', function ($query) use ($now) {
                $query->where('mulai_absen', '<', $now)->where('akhir_absen', '>', $now);
            })
            ->first();

        if ($getDataAbsen) {
            $getDataAbsen->update([
                'waktu_absen' => $now,
            ]);
            // dd('sukses');
            return redirect()->back()->with('sukses', ' absen berhasi');
        } else {
            // dd('gagal');
            return redirect()->back()->with('error', ' Tidak Ada Jadwal sekarang');
        }

    }

    public function generateAlpa()
    {
        $today = Carbon::now();
        $jumlahDataToday = Absenhalaqah::where('tanggal', $today->toDateString());
        $NotAbsenHalaqah = Absenhalaqah::where('tanggal', $today->toDateString())
            ->where('status_kehadiran', null);

        if ($NotAbsenHalaqah->count() >= $jumlahDataToday->count()) {
            $jumlahDataToday->delete();
        } else {
            $NotAbsenHalaqah->update([
                'status_kehadiran' => 'alpa',
            ]);
        }

    }

    public function generateAbsenSekolah()
    {
        $today = Carbon::now();

        $rosterToday = Roster::with('jammengajar', 'rombel')->whereNotNull('user_id')->whereHas('jammengajar', function ($query) use ($today) {
            $query->where('hari', $today->dayOfWeek);
        })->get();

        foreach ($rosterToday as $roster) {
            Absensekolah::create([
                'user_id' => $roster->user_id,
                'tanggal' => $today->toDateString(),
                'jam_ke' => $roster->jammengajar->jam_ke,
                'mulai_kbm' => $roster->jammengajar->mulai_kbm,
                'akhir_kbm' => $roster->jammengajar->akhir_kbm,
                'rombel_id' => $roster->rombel_id,
                'sekolah_id' => $roster->rombel->sekolah_id,
                'mapel_id' => $roster->mapel_id,
            ]);
        }

        dd('success');

    }

    public function generateAlpaAbsenSekolah()
    {
        $today = Carbon::now();
        $sekolahs = Sekolah::all();

        foreach ($sekolahs as $sekolah) {
            $jumlahabsen = Absensekolah::where('sekolah_id', $sekolah->id)->where('tanggal', $today->toDateString())->count();
            $jumlahnull = Absensekolah::where('sekolah_id', $sekolah->id)->where('tanggal', $today->toDateString())->where('kehadiran', null)->count();

            if ($jumlahnull >= $jumlahabsen) {
                Absensekolah::where('sekolah_id', $sekolah->id)->where('tanggal', $today->toDateString())->delete();
            } else {
                Absensekolah::where('sekolah_id', $sekolah->id)->where('tanggal', $today->toDateString())->where('kehadiran', null)->update([
                    'kehadiran' => 'alpa',
                ]);
            }
        }

        dd('success');

    }

}
