<div class="w-full" x-data="{ popup: false, imageUrl: '' }">
    <div class="flex items-center justify-between">
        <h3 class="font-bold text-red-800">{{ __('Absen Terakhir') }}</h3>
        <div>
            <a href="{{ route('v2.absen-pegawai') }}" class="p-2 text-sm text-red-500 border rounded">View All</a>
        </div>
    </div>
    @if (Auth::user()->is_karyawan)
        <button onclick="warning()" class="flex items-center p-2 my-2 text-sm text-white bg-red-700 rounded-lg border-1 hover:ring-2 hover:ring-red-300">
            <svg class="w-4 h-w-4 " stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9"/>
            </svg>
            <span class="ms-2">
                Absen Dinas Luar
            </span>
        </button>
    @endif
    <ul class="divide-y-2 divide-gray-300 dark:divide-gray-700">
        @forelse ($absen as $item)
            <li class="py-4">
                <p class="font-semibold tracking-wide">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d-M-Y') }}</p>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                    @foreach(['masuk_1', 'masuk_2', 'pulang'] as $type)
                        @php
                            $detail = $item->$type;
                        @endphp
                        @if ($detail)
                            <div class=" relative flex items-center justify-start gap-4 p-4 transition duration-500 border rounded-xl bg-gray-50 dark:bg-gray-800 hover:bg-gray-200 hover:ring-2 hover:ring-gray-200 hover:border hover:border-white hover:border-dashed {{ $detail->absendinasluars ? 'border-red-100 animate-pulse bg-red-50 ' :'' }} ">
                                <a href="javascript:void(0)" x-on:click="popup = true; imageUrl = '{{ asset('storage/public/images/karyawan/' . $detail->image) }}'">
                                    <img src="{{ asset('storage/public/images/karyawan/' . $detail->image) }}" class="w-20 h-20 transition duration-500 rounded-xl min-w-20 hover:scale-125" alt="">
                                </a>
                                <div>
                                    <p class="text-sm font-bold">{{ strtoupper(str_replace('_', ' ', $detail->type)) }}</p>
                                    <time class="text-sm">Jam Absen : {{ $detail->jam }}</time>
                                    <p class="text-sm">{{ $detail->type == 'pulang' ? 'Pulang cepat' : 'Terlambat' }} : {{ $detail->selisih_waktu ? $detail->selisih_waktu . ' Menit' : '0 Menit' }}</p>
                                    <a href="https://www.google.com/maps?q={{ $detail->lokasi }}" target="_blank" class="text-sm text-blue-700 hover:underline hover:underline-offset-1">Lihat Lokasi</a>
                                    @if ($detail->absendinasluars)
                                        <x-tooltipabsendinasluar :data="$detail->absendinasluars"></x-tooltipabsendinasluar>
                                    @endif
                                </div>
                            </div>
                        @else
                        <div class="flex items-center justify-start gap-4 p-4 border rounded-xl bg-gray-50 dark:bg-gray-800">
                            <a href="javascript:void(0)" x-on:click="popup = true; imageUrl = '{{ asset('assets/images/avatar.png') }}'">
                                <img src="{{ asset('assets/images/avatar.png') }}" class="w-20 h-20 rounded-xl" alt="">
                            </a>
                            <div>
                                <p class="text-sm font-bold">{{ strtoupper(str_replace('_', ' ', $type)) }}</p>
                                <p class="text-sm text-red-700">{{ __('Tidak Ada Data') }}</p>
                                
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </li>
        @empty
            <p>No records found</p>
        @endforelse
    </ul>


    <div x-show="popup" class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-50 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500 bg-opacity-50">
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
    
    @push('script')
    <script>
        function warning(){
            Swal.fire({
                title: "Absen Dinas Luar",
                text: "Absen dengan metode ini tidak masuk langsung ke data asben, sebelum di Approve oleh kepala bidang",
                showCancelButton: true,
                confirmButtonText: "Lanjut",
                }).then((result) => {
                if (result.isConfirmed) {
                    const route = "{{ route('v2.dinasluar') }}";
                    window.location.href = route;
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    </script>
        
    @endpush

</div>
