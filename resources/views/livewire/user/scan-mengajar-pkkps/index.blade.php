<div>
    @if (!is_null($absen) || !is_null($roster))

        <div class="flex items-center gap-4 p-4 mb-4 bg-red-200 border-2 border-white rounded-lg shadow-md animate-pulse">
            <img src="{{ asset('assets/images/worker.png') }}" alt="img" class="h-full rounded max-h-28 aspect-square">
            <div>
                <p class="mb-2 text-xs md:text-sm">
                    {{ __('Saat ini anda memiliki jam mengajar') }}
                </p>
                <div class="text-xs md:text-sm">
                    <dl class="flex gap-4">
                        <dt class="text-gray-500">Mulai Jam</dt>
                        <dd class="font-bold">{{ !is_null($absen) ? $absen->mulai_kbm .' s/d '. $absen->akhir_kbm  :$roster->jammengajar->mulai_kbm .' s/d '. $roster->jammengajar->akhir_kbm }}</dd>
                    </dl>
                    <dl class="flex gap-4">
                        <dt class="text-gray-500">Kelas</dt>
                        <dd class="font-bold">{{ !is_null($absen) ? ucWords($absen->rombel->nama_rombel):  ucWords($roster->rombel->nama_rombel)}}</dd>
                    </dl>
                    <dl class="flex gap-4">
                        <dt class="text-gray-500">mapel</dt>
                        <dd class="font-bold">{{ !is_null($absen) ? $absen->mapel->mata_pelajaran: $roster->mapel->mata_pelajaran}}</dd>
                    </dl>
                    <div class="mt-4">
                        @if ( $absen && $absen->kehadiran =='alpa')
                            <a href="{{ route('v2.absen-mengajar-pkkps',$absen->id)}}" class="p-2 text-xs text-white bg-red-700 rounded-lg md:text-sm">Absen Sekarang</a>
                        @elseif ($absen && $absen->kehadiran !='alpa')
                            {{-- @if ($absen->absensiswa->isEmpty())
                                <p class="text-red-600">Anda Belum Absensi Siswa Pada Kelas Ini!!</p>
                                <div class="my-4">
                                    <a href="{{ route('v2.absen-siswa',$absen->id)}}" class="p-2 text-xs text-white bg-red-700 rounded-lg md:text-sm">Absen Sekarang</a>
                                </div>
                            @endif --}}
                            <p class="text-sm font-semibold text-green-600">Sudah absen pada jam {{ $absen->waktu_absen }}, Terlambat {{ $absen->keterlambatan .' Menit' }}</p>
                            
                        @else
                            <a href="{{ route('v2.absen-pkkps-rombel',$roster->rombel_id) }}" class="p-2 text-xs text-white bg-red-700 rounded-lg md:text-sm">Absen Sekarang</a>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    @endif
</div>

