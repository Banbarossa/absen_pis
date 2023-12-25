<?php

namespace App\Console\Commands;

use App\Mail\CreateUpdateAbsen;
use App\Models\Absenhalaqah;
use App\Models\Absensekolah;
use App\Models\JadwalHalaqah;
use App\Models\Roster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GenerateAbsens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-absens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // generate Abasen Halaqah
        $userWithAksesHalaqah = User::role('musyrif halaqah')->get();

        $today = Carbon::now();

        $jadwalHalaqah = JadwalHalaqah::where('hari', $today->dayOfWeek)->get();

        if ($jadwalHalaqah && $userWithAksesHalaqah) {
            foreach ($jadwalHalaqah as $jadwal) {
                foreach ($userWithAksesHalaqah as $user) {
                    Absenhalaqah::firstOrCreate([
                        "jadwal_halaqah_id" => $jadwal->id,
                        "user_id" => $user->id,
                        "tanggal" => $today->toDateString(),
                    ]);
                }

            }
        }

        // Generate Absen Mengajar

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
                'jumlah_jam' => $roster->jammengajar->jumlah_jam,
            ]);
        }
        $data = 'Data Absen Berhasil di generate';

        Mail::to('banbarossa@gmail.com')->send(new CreateUpdateAbsen($data));
    }
}
