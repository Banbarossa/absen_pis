<div class="w-full" x-data="{ popup: false, imageUrl: '' }">
    <h3>{{ __('Absen Terakhir') }}</h3>
    <ul class="divide-y-2 divide-gray-300 dark:divide-gray-700">
        @forelse ($absen as $item)
            <li class="py-4">
                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d-M-Y') }}
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach ($item->absenkaryawandetails as $detail)
                        <div class="flex items-center justify-start gap-4 p-4 border rounded-xl bg-gray-50 dark:bg-gray-800">
                            <a href="javascript:void(0)" x-on:click="popup = true; imageUrl = '{{ asset('storage/images/karyawan/' . $detail->image) }}'">
                                <img src="{{ asset('storage/images/karyawan/' . $detail->image) }}" class="w-20 h-20 rounded-xl" alt="">
                            </a>
                            <div>
                                <p class="text-sm font-bold">{{ strtoupper(str_replace('_',' ',$detail->type)) }}</p>
                                <time class="text-sm">Jam Absen : {{ $detail->jam }}</time>
                                <p class="text-sm">Terlambat : {{ $detail->selisih_waktu ? $detail->selisih_waktu .'Menit':'' }}</p>
                                <a href="https://www.google.com/maps?q={{ $detail->lokasi}}" target="blank">Lihat Lokasi</a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </li>
        @empty
            <li>{{ __('Data Not Found') }}</li>
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
