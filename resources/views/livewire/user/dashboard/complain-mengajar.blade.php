<div class="w-full p-4 bg-white rounded-lg md:w-1/2">
    <p class="mb-1">Bismillah,</p>
    <p>Saya <strong>{{ Auth::user()->name }}</strong>, dengan ini membuat pernyataan bahwa:</p>
    {{-- "user_id" => 36
    "tanggal" => "2024-02-07"
    "jam_ke" => "7-8"
    "mulai_kbm" => "14:30:00"
    "akhir_kbm" => "15:50:00"
    "rombel_id" => 3
    "sekolah_id" => 1
    "mapel_id" => 27
    "waktu_absen" => null
    "keterlambatan" => null
    "kehadiran" => "alpa"
    "jumlah_jam" => 2
    "in_location" => null
    "latitude" => null
    "longitude" => null
    "image" => null
    "created_at" => "2024-02-07 12:05:13"
    "updated_at" => "2024-02-07 12:05:13" --}}
    <table class="my-2">
        <tbody>
            <tr>
                <td class="pr-2">Hari, Tanggal</td>
                <td class="pr-2">:</td>
                <th class="text-left">{{ \Carbon\Carbon::createFromFormat('Y-m-d',$absen->tanggal)->locale('id')->format('l, d M Y') }}</th>
            </tr>
            <tr>
                <td class="pr-2">Kelas</td>
                <td class="pr-2">:</td>
                <th class="text-left">{{ $absen->rombel->nama_rombel }}</th>
            </tr>
            <tr>
                <td class="pr-2">Jam Ke</td>
                <td class="pr-2">:</td>
                <th class="text-left">{{ $absen->jam_ke }}</th>
            </tr>
            <tr>
                <td class="pr-2">Mata Pelajaran</td>
                <td class="pr-2">:</td>
                <th class="text-left">{{ $absen->mapel->mata_pelajaran }}</th>
            </tr>
        </tbody>
    </table>

    <p class="mb-2">Pada jam tersebut saya tidak dapat melakukan absen barcode disebabkan karena</p>
    <form action="" wire:submit.prevent='store'>
        <div>
            <textarea id="reason" wire:model='reason' rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500 " placeholder="Tuliskan Alasan anda dengan jelas disini."></textarea>
            <x-input-error class="my-2" :messages="$errors->get('reason')"></x-input-error>
        </div>

        <p class="my-2">Dan Pada jam tersebut saya</p>

        <div>
            <select id="change_to" wire:model='change_to' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 ">
                <option>Pilih Salah Satu</option>
                <option value="izin pribadi">Izin Pribadi</option>
                <option value="izin dinas">Izin Dinas</option>
                <option value="sakit">Sakit</option>
                <option value="hadir">Hadir</option>
            </select>
            <x-input-error class="my-2" :messages="$errors->get('change_to')"></x-input-error>
        </div>
        
        <p class="my-2">Demikian Pengajuan Komplain saya, agar menjadi pertimbangan</p>

        <x-primary-button>Ajukan</x-primary-button>
    </form>


</div>
