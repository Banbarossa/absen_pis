<div class="p-4 bg-white rounded-xl">
    @php
    $hariMapping = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        0 => 'Minggu',
    ];
    @endphp


    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-6">
        @role('musyrif halaqah')
        @foreach($rosters as $hari => $groupedRosters)
        <div>
            <div class="p-4 mb-4 text-center bg-red-200 border-2 border-white border-dashed rounded-lg ring-2 ring-red-200">
                <h2 class="text-lg font-bold">{{ $hariMapping[$hari] }}</h2>
            </div>
            <ul>
                @foreach($groupedRosters as $roster)

                @php
                $is_now = false;
                if ($today == $roster->hari && $now >= \Carbon\Carbon::createFromFormat('H:i:s',$roster->mulai_absen) && $now <= \Carbon\Carbon::createFromFormat('H:i:s',$roster->akhir_absen)) {
                    $is_now =true;
                }
                @endphp


                <li class="p-4 mb-4 space-y-2 transition duration-500 {{ $is_now ?'bg-red-300 animate-pulse' : 'bg-gray-100'}}  border-2 border-dashed rounded-lg hover:bg-gray-200 hover:scale-105 hover:rotate-1 hover:border-white hover:ring-2 hover:ring-gray-200">
                        <p class="text-sm">Nama Sesi: <span class="font-bold">{{ $roster->nama_sesi }}</span> </p>
                        <p class="text-sm">Jam Absen : <span class="font-bold">{{ $roster->mulai_absen .' s/d '. $roster->akhir_absen}}</span></p>
                    </li>
                @endforeach
            </ul>
        </div>
        @endforeach
        @else
        <div class="my-4 text-sm text-gray-700 md:col-span-3 lg:col-span-6">
            Hanya Bisa di Akses oleh Musyrif Halaqah
        </div>
        @endrole
    </div>



</div>
