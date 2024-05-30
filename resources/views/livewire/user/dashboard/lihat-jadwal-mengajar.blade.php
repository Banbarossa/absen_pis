<div class="p-4 bg-white rounded-xl">
    @php
    $hariMapping = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];
    @endphp

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-6">
        @foreach($rosters as $hari => $groupedRosters)
        <div>
            <div class="p-4 mb-4 text-center bg-red-200 border-2 border-white border-dashed rounded-lg ring-2 ring-red-200">
                <h2 class="text-sm font-bold md:text-base">{{ $hariMapping[$hari] }}</h2>
            </div>
            <ul>
                @foreach($groupedRosters as $roster)

                @php
                $is_now = false;
                if ($today == $roster->jammengajar->hari && $now >= \Carbon\Carbon::parse($roster->jammengajar->mulai_kbm)->format("H:i:s") && $now <= \Carbon\Carbon::parse($roster->jammengajar->akhir_kbm)->format("H:i:s")) {
                    $is_now =true;
                }
                @endphp


                <li class="p-4 mb-4 space-y-2 transition duration-500 {{ $is_now ?'bg-red-300 animate-pulse' : 'bg-gray-100'}}  border-2 border-dashed rounded-lg hover:bg-gray-200 hover:scale-105 hover:rotate-1 hover:border-white hover:ring-2 hover:ring-gray-200">
                    
                        <p class="text-xs md:text-sm">Rombel: <span class="font-bold">{{ $roster->rombel->nama_rombel }}</span> </p>
                        <p class="text-xs md:text-sm">Jam Ke: <span class="font-bold">{{ $roster->jammengajar->jam_ke }}</span></p>
                        <p class="text-xs md:text-sm">Mata Pelajaran: <span class="font-bold">{{ $roster->mapel->mata_pelajaran }}</span> </p>
                        <p class="text-xs md:text-sm">Mata Pelajaran: <span class="font-bold">{{ $roster->mapel->mata_pelajaran }}</span> </p>
                        <p class="text-xs font-bold md:text-sm">{{$roster->jammengajar->mulai_kbm}} s/d {{$roster->jammengajar->akhir_kbm }}</span> </p>
                    </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>



</div>
