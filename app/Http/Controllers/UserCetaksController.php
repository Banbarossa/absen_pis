<?php

namespace App\Http\Controllers;

use App\Models\JadwalHalaqah;
use App\Models\Roster;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;

class UserCetaksController extends Controller
{
    public function cetakJadwalHalaqah()
    {
        $jadwals = JadwalHalaqah::orderBy('hari', 'asc')
            ->orderBy('nama_sesi', 'desc')
            ->get()
            ->groupBy('hari');

        return view('user-cetak.jadwal-halaqah', [
            'jadwals' => $jadwals,
        ]);
    }

    public function cetakJadwalMengajar()
    {
        $semesterAktif = Semester::whereStatus(1)->first();
        $roster = Roster::with('jammengajar', 'mapel', 'rombel')
            ->leftjoin('jammengajars', 'rosters.jammengajar_id', '=', 'jammengajars.id')
            ->where('user_id', Auth::user()->id)
            ->where('semester_id', $semesterAktif->id)
            ->orderBy('jammengajars.hari', 'asc')
            ->orderBy('jammengajars.jam_ke', 'asc')
            ->get();

        $userName = Auth::user()->name;
        $semester = $semesterAktif->nama_semester;
        $tahun_ajaran = $semesterAktif->tahun;

        return view('user-cetak.jadwal-mengajar', [
            'rosters' => $roster,
            'userName' => $userName,
            'semester' => $semester,
            'tahun_ajaran' => $tahun_ajaran,

        ]);

    }
}
