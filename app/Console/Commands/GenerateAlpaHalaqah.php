<?php

namespace App\Console\Commands;

use App\Mail\CreateUpdateAbsen;
use App\Models\Absenhalaqah;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GenerateAlpaHalaqah extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-alpa-halaqah';

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
        $today = Carbon::now();
        $jumlahDataToday = Absenhalaqah::where('tanggal', $today->toDateString());
        $NotAbsenHalaqah = Absenhalaqah::where('tanggal', $today->toDateString())
            ->where('kehadiran', null);

        if ($NotAbsenHalaqah->count() >= $jumlahDataToday->count()) {
            $jumlahDataToday->delete();
        } else {
            $NotAbsenHalaqah->update([
                'kehadiran' => 'alpa',
            ]);
        }

        $data = 'Guru yang tidak absen berhasil diubah menjadi alpa';

        Mail::to('banbarossa@gmail.com')->send(new CreateUpdateAbsen($data));
    }
}
