<?php

use App\Http\Controllers\AbsenAlternatifController;
use App\Http\Controllers\AbsenHalaqahController;
use App\Http\Controllers\AbsenMengajarController;
use App\Http\Controllers\ChatifyController;
use App\Http\Controllers\GuestAbsenHalaqahController;
use App\Http\Controllers\GuestAbsenKaryawan;
use App\Http\Controllers\GuestAbsenSecurityCekLokasi;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserCetaksController;
use App\Livewire\AbsenMengajarBarcode;
use App\Livewire\Admin\AbsenHalaqahToday;
use App\Livewire\Admin\DetailRombel;
use App\Livewire\Admin\KelolaAbsenHalaqah;
use App\Livewire\Admin\KelolaAsatizah;
use App\Livewire\Admin\KelolaComplainHalaqah;
use App\Livewire\Admin\KelolaJadwalHalaqah;
use App\Livewire\Admin\KelolaMataPelajaran;
use App\Livewire\Admin\KelolaRombel;
use App\Livewire\Admin\KelolaSchedule;
use App\Livewire\Admin\KelolaSekolah;
use App\Livewire\Admin\Laporan\LaporanAll;
use App\Livewire\Admin\Laporan\LaporanPerRombel;
use App\Livewire\Admin\Laporan\LaporanPerSekolah;
use App\Livewire\Admin\LuarJadwal\AbsenLuarJadwal;
use App\Livewire\Admin\MusyrifHalaqah;
use App\Livewire\Admin\PengaturanSemester;
use App\Livewire\Admin\RekapHalaqahMonthly;
use App\Livewire\Admin\RoleUserManage;
use App\Livewire\Admin\Security\LaporanSecurity;
use App\Livewire\Admin\Security\LokasiAbsen;
use App\Livewire\Admin\User;
use App\Livewire\Admin\Welcome\Informasi;
use App\Livewire\Admin\Welcome\InformasiCreate;
use App\Livewire\Admin\Welcome\Pengetahuan;
use App\Livewire\Admin\Welcome\PengetahuanCreate;
use App\Livewire\Hrd\CreateJadwalKaryawan;
use App\Livewire\Hrd\GroupingUserToBagian;
use App\Livewire\Hrd\JamAbsenKaryawan;
use App\Livewire\Hrd\LaporanAbsenKaryawan;
use App\Livewire\Hrd\LaporanBulanan;
use App\Livewire\Hrd\UpdateJadwalKaryawan;
use App\Livewire\KelolaKomplainMengajar;
use App\Livewire\Kepsek\AbsenMengajarGuru;
use App\Livewire\Kepsek\RekapMengajar;
use App\Livewire\Piket\KelolaAbsenAlternatif;
use App\Livewire\Piket\KelolaAbsenMengajar;
use App\Livewire\User\AbsenMengajar;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Halaqah;
use App\Livewire\User\UserProfile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::view('success', 'halaman-success-absen')->name('success.page');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('user/cetak-jadwal-halaqah', [UserCetaksController::class, 'cetakJadwalHalaqah'])->name('cetak.jadwal-halaqah');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    // Route::get('user-dashboard', [UserDashboard::class, 'index']);

    Route::get('user-profile', UserProfile::class); //user update Profile

    // get unread message on topbar with ajax
    Route::get('/unread-messages', [ChatifyController::class, 'getUnreadMessages'])->name('unread-messages');

    // user Area
    Route::group(['middleware' => 'auth', 'prefix' => 'user/absen', 'as' => 'user.absen.'], function () {
        Route::get('harian', \App\Livewire\User\Harian::class)->name('harian');
        Route::get('halaqah', Halaqah::class)->name('halaqah')->middleware('role:musyrif halaqah');
        Route::get('mengajar', AbsenMengajar::class)->name('mengajar')->middleware('role:guru');
        Route::get('jadwal', [UserCetaksController::class, 'cetakJadwalMengajar'])->name('jadwal')->middleware('role:guru');

    });

    // Admin dan Pengajaran
    Route::group(['middleware' => ['auth', 'role:admin|pengajaran'], 'prefix' => 'pengajaran', 'as' => 'pengajaran.'], function () {
        Route::get('rombel', KelolaRombel::class)->name('rombel');
        Route::get('schedule', KelolaSchedule::class)->name('schedule');
        Route::get('kelola-guru', KelolaAsatizah::class)->name('guru');
        Route::get('detail-rombel/{id}', DetailRombel::class)->name('detail.rombel');
        Route::get('mata-pelajaran', KelolaMataPelajaran::class)->name('mapel');
        Route::get('informasi', Informasi::class)->name('informasi');
        Route::get('informasi-create', InformasiCreate::class)->name('informasi.create');
        Route::get('informasi-update/{id}', InformasiCreate::class)->name('informasi.update');
        Route::get('pengetahuan', Pengetahuan::class)->name('pengetahuan');
        Route::get('pengetahuan-create', PengetahuanCreate::class)->name('pengetahuan.create');
        Route::get('pengetahuan-update/{id}', PengetahuanCreate::class)->name('pengetahuan.update');
    });

    // Admin Area
    Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('user', User::class)->name('user');
        Route::get('role', RoleUserManage::class)->name('user.role');

        Route::get('sekolah', KelolaSekolah::class);
        Route::get('semester', PengaturanSemester::class);
        Route::get('complain-mengajar', KelolaKomplainMengajar::class)->name('complain.mengajar');
    });

    Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin/security', 'as' => 'admin.security.'], function () {
        Route::get('lokasi', LokasiAbsen::class)->name('lokasi');
        Route::get('laporan', LaporanSecurity::class)->name('laporan');
    });

    // hrd area
    Route::group(['middleware' => ['auth', 'role:hrd|admin'], 'prefix' => 'laporan', 'as' => 'laporan.'], function () {
        Route::get('detail/personal', LaporanBulanan::class)->name('detail.personal');
        Route::get('sekolah/{id}', LaporanPerSekolah::class)->name('sekolah');
        Route::get('rombel', LaporanPerRombel::class)->name('rombel');
        Route::get('collective', LaporanAll::class)->name('semua');
        Route::get('laporan-absen-karyawan', LaporanAbsenKaryawan::class)->name('karyawan');
        // Route::get('hrd-pengaturan-absen-karyawan', JamAbsenKaryawan::class);
        // Route::get('hrd-setting-absen', SettingJamKaryawan::class);

    });
    Route::group(['middleware' => ['auth', 'role:hrd|admin'], 'prefix' => 'admin/pengaturan', 'as' => 'admin.pengaturan.'], function () {
        Route::get('jam-karyawan', JamAbsenKaryawan::class)->name('jam-karyawan');
        Route::get('jam-karyawan/create/{id}', CreateJadwalKaryawan::class)->name('jam-karyawan.create');
        Route::get('jam-karyawan/edit/{id}', UpdateJadwalKaryawan::class)->name('jam-karyawan.update');
        Route::get('grouping-karyawan', GroupingUserToBagian::class)->name('grouping-user');
        // Route::get('hrd-absen-karyawan', LaporanAbsenKaryawan::class);
        // Route::get('hrd-setting-absen', SettingJamKaryawan::class);

    });

    //Area Koordinatro Halaqah
    Route::group(['middleware' => ['auth', 'role:koordinator halaqah'], 'prefix' => 'admin/halaqah', 'as' => 'admin.halaqah.'], function () {
        Route::get('jadwal', KelolaJadwalHalaqah::class)->name('jadwal');
        Route::get('complain', KelolaComplainHalaqah::class)->name('complain');
        Route::get('musyrif', MusyrifHalaqah::class)->name('musyrif');
        Route::get('laporan', KelolaAbsenHalaqah::class)->name('laporan');
        Route::get('absen-today', AbsenHalaqahToday::class)->name('absen.today');
        Route::get('rekap', RekapHalaqahMonthly::class)->name('rekap');
    });

    // Area Kepala Sekolah
    Route::middleware(['checkSchoolAccess'])->group(function () {
        Route::get('kepsek/absen-guru', AbsenMengajarGuru::class);
        Route::get('kepsek/rekap-absen-guru', RekapMengajar::class);
    });

    // piket
    Route::group(['middleware' => ['role:piket']], function () {
        Route::get('piket/absen', KelolaAbsenMengajar::class)->name('piket.absen');
        Route::get('piket/absen-luarjadwal', AbsenLuarJadwal::class)->name('piket.luarjadwal');
        Route::get('piket/absen-alternatif', KelolaAbsenAlternatif::class)->name('pike.absen.alternatif');

    });

});

require __DIR__ . '/auth.php';

Route::get('generate/absen-halaqah', [AbsenHalaqahController::class, 'generateAbsen']); //generate absen perhari
Route::get('generate-alpa', [AbsenHalaqahController::class, 'generateAlpa']); //generate Alpa
Route::get('generate-absen-sekolah', [AbsenHalaqahController::class, 'generateAbsenSekolah']); //generate absen sekolah
Route::get('generate-alpa-absen-sekolah', [AbsenHalaqahController::class, 'generateAlpaAbsenSekolah']); //generate alpa absen sekolah

Route::get('user-absen', [AbsenHalaqahController::class, 'userAbsen']); //sudah lupa

// Route::get('absen-halaqah', AbsenHaqalah::class); //absen halaqah oleh guest
Route::get('absen-mengajar-barcode/{id}', AbsenMengajarBarcode::class); //absen mengajar oleh guest

// Absen Karyawan
Route::get('absen-karyawan/{name}', [GuestAbsenKaryawan::class, 'index'])->name('absen-karyawan.index'); //aksen absen karyawan
Route::post('absen-karyawan/', [GuestAbsenKaryawan::class, 'store'])->name('absen-karyawan.store'); //simpan data absen karyawan
// Route::get('absen-dinasluar/{name}', [GuestAbsenKaryawan::class, 'absendinasluar'])->name('absen-dinasluar.index'); //aksen absen karyawan
// Route::post('absen-dinasluar/', [GuestAbsenKaryawan::class, 'storeDinasluar'])->name('absen-dinasluar.store'); //simpan data absen karyawan

// Absen Mengajar Kelas
Route::get('absen-mengajar/{code}', [AbsenMengajarController::class, 'index'])->name('absen-mengajar.index'); //aksen absen mengajar
Route::post('absen-mengajar/{id}', [AbsenMengajarController::class, 'store'])->name('absen-mengajar.store'); //simpan data absen mengajar

// Absen Mengajar Pengganti
Route::get('absen-alternatif/{code}', [AbsenAlternatifController::class, 'alternatifIndex'])->name('absen-alternatif.index'); //aksen absen alternatif
Route::post('absen-alternatif/{code}', [AbsenAlternatifController::class, 'alternatifStore'])->name('absen-alternatif.store'); //simpan data absen alternatif

// Absen Mengajar Pengganti
Route::get('absen-pengganti/{code}', [AbsenAlternatifController::class, 'penggantiIndex'])->name('absen-pengganti.index'); //aksen absen alternatif
Route::post('absen-pengganti/{code}', [AbsenAlternatifController::class, 'penggantiStore'])->name('absen-pengganti.store'); //simpan data absen alternatif

// Absen Halaqah
Route::get('absen-halaqah', [GuestAbsenHalaqahController::class, 'index'])->name('absen-halaqah.index');
Route::post('absen-halaqah', [GuestAbsenHalaqahController::class, 'store'])->name('absen-halaqah.store');
Route::get('absen-halaqah-khusus', [GuestAbsenHalaqahController::class, 'khusus'])->name('absen-halaqah.khusus');
Route::post('absen-halaqah-khusus', [GuestAbsenHalaqahController::class, 'storeKhusus'])->name('absen-halaqah.store-khusus');

// Absen Karyawan
Route::get('absen-security/{code}', [GuestAbsenSecurityCekLokasi::class, 'index'])->name('absen-security.index'); //aksen absen security lokasi
Route::post('absen-security/{code}', [GuestAbsenSecurityCekLokasi::class, 'store'])->name('absen-security.store'); //simpan data absen security lokasi

Route::group(['middleware' => 'auth', 'prefix' => 'v2', 'as' => 'v2.'], function () {
    Route::view('/', 'user-tailwind.dashboard.index')->name('dashboard');
    Route::get('home/profile', \App\Livewire\User\Profile\Index::class)->name('profile');
    Route::get('home/absen-pegawai', \App\Livewire\User\Dashboard\ViewAllAbsenPegawai::class)->name('absen-pegawai');
    Route::get('home/absen-mengajar', \App\Livewire\User\Dashboard\ViewAllAbsenMengajar::class)->name('absen-mengajar');
    Route::get('home/absen-halaqah', \App\Livewire\User\Dashboard\ViewAllAbsenHalaqah::class)->name('absen-halaqah');
    Route::get('home/jadwal-mengajar', \App\Livewire\User\Dashboard\LihatJadwalMengajar::class)->name('jadwal.mengajar');
    Route::get('home/jadwal-halaqah', \App\Livewire\User\Dashboard\LihatJadwalHalaqah::class)->name('jadwal.halaqah');
    Route::get('home/complain-absen-mengajar/{absen}', \App\Livewire\User\Dashboard\ComplainMengajar::class)->name('complain.mengajar');
    Route::get('home/complain-absen-halaqah/{absen}', \App\Livewire\User\Dashboard\ComplainHalaqah::class)->name('complain.halaqah');

    Route::get('dinasluar', [GuestAbsenKaryawan::class, 'absendinasluar'])->name('dinasluar');
    Route::post('absen-dinasluar/{type}', [GuestAbsenKaryawan::class, 'storeDinasluar'])->name('dinasluar.store');

    Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
        Route::get('akun', \App\Livewire\NewAdmin\Akun\Index::class)->name('akun');
    });

});
