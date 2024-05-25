<div class="w-full" x-data="{ popup: false, imageUrl: '' }">
    <div class="flex items-center justify-between">
        <h3 class="font-bold text-red-800">{{ __('Absen Hari Ini') }}</h3>
        <div>
            <a href="{{ route('baru.jadwal.mengajar') }}" class="p-2 text-sm text-red-500 border rounded">Lihat Jadwal</a>
            <a href="{{ route('baru.absen-pegawai') }}" class="p-2 text-sm text-red-500 border rounded">View All</a>
        </div>
    </div>
    <ul class="divide-y-2 divide-gray-300 dark:divide-gray-700">
        @forelse ($absenToday as $item)
            <li class="py-4">
                <p class="font-semibold tracking-wide">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d-M-Y') }}</p>
                <div class="flex items-center justify-start gap-6 p-4 border rounded-xl bg-gray-50 dark:bg-gray-800">
                    <div class="text-center">
                        @if ($item->image)
                        <a href="javascript:void(0)" x-on:click="popup = true; imageUrl = '{{ asset('storage/public/images/' . $item->image) }}'">
                            <img src="{{asset('storage/public/images/'.$item->image)}}" class="w-20 h-20 rounded-xl min-w-20" alt="">
                        </a>
                        @else
                        <a href="javascript:void(0)" x-on:click="popup = true; imageUrl = '{{ asset('assets/images/avatar.png') }}'">
                            <img src="{{asset('assets/images/avatar.png')}}" class="w-20 h-20 rounded-xl min-w-20" alt="">
                        </a>
                        @endif
                        <p class="font-bold mt-2 tracking-wider {{ $item->kehadiran == 'alpa' ? 'text-red-700' :'text-gray-700' }}">{{ strtoupper($item->kehadiran) }}</p>
                    </div>
                    <div class="grid w-full grid-cols-1 md:grid-cols-2">
                        <div>
                            <p class="text-sm font-bold">Kelas : {{ $item->rombel? $item->rombel->nama_rombel :'Undefined' }}</p>
                            <p class="text-sm font-bold">Jam Ke : {{ $item->jam_ke }}</p>
                            <p class="text-sm font-bold">mata Pelajaran : {{ $item->mapel ? $item->mapel->mata_pelajaran :'Undefined' }}</p>
                            <p class="text-sm {{ !$item->in_location ?"text-red-700":"" }}">Dalam radius : {{ $item->in_location ? "Ya":"tidak" }}</p>
                            <a href="https://www.google.com/maps?q={{ $item->latitude.','.$item->latitude }}" target="_blank" class="text-sm text-blue-700 hover:underline hover:underline-offset-1">Lihat Lokasi</a>
                        </div>
                        <div>
                            <p class="text-sm font-bold">Mulai KBM : {{ $item->mulai_kbm }}</p>
                            <p class="text-sm font-bold">Scan Masuk : {{ $item->waktu_absen }}</p>
                            <p class="text-sm font-bold">Jam Ke : {{ $item->jam_ke }}</p>
                            <p class="text-sm">Terlambat : {{ $item->keterlambatan ? $item->keterlambatan . ' Menit' : '0 Menit' }}</p>
                            <p class="text-sm">Jumlah Jam : {{ $item->jumlah_jam.' J/P' }}</p>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <p>Tidak Ada Data yang Ditemukan</p>
        @endforelse
    </ul>


    <div x-show="popup" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-50 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500 bg-opacity-50">
        <div class="relative w-full max-w-lg max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" @click.outside="popup = false">
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-white">
                        Gambar
                    </h3>
                    <button type="button" x-on:click="popup = false" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 space-y-4 md:p-5">
                    <img :src="imageUrl" alt="Zoomed Image" class="w-full h-full shadow-md rounded-2xl">
                </div>
                <div class="flex items-center px-4 py-2 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                    <button
                        x-on:click="popup = false"
                        type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
