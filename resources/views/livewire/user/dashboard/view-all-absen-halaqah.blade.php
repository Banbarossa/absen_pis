<div class="w-full p-4 bg-white rounded-lg" x-data="{ popup: false, imageUrl: '' }">
    <div class="flex items-center justify-start w-full gap-4 mb-6">
        <div>
            <x-input-label for="startDate">{{ __('Tanggal Awal') }}</x-input-label>
            <x-text-input-tailwind id="startDate" wire:model.live='startDate' type="date" class="w-full md:w-auto"></x-text-input-tailwind>
        </div>
        <div>
            <x-input-label for="endDate">{{ __('Tanggal Akhir') }}</x-input-label>
            <x-text-input-tailwind id="endDate" wire:model.live='endDate' type="date" class="w-full md:w-auto"></x-text-input-tailwind>
        </div>
    </div>
    <ul class="grid grid-cols-1 gap-4 mt-2 lg:grid-cols-2">
        @forelse ($absens as $item)
            <li class="p-4 py-4 mb-3 border rounded-xl bg-gray-50 {{ $item->kehadiran == 'alpa' ? 'bg-red-100 animate-pulse' :'' }}">
                <p class="font-semibold tracking-wide text-gray-700">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d-M-Y') }}</p>
                <div class="flex items-center justify-start gap-6 ">
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
                        <p class="font-bold mt-2 tracking-wider {{ $item->kehadiran == 'alpa' ? 'text-red-700' :'text-gray-700' }}"></p>
                    </div>
                    <div class="w-full ">
                        <div>
                            <p class="text-sm">Hari/ Tanggal : <span class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d M Y') }}</span></p>
                            <p class="text-sm">Sesi : <span class="font-semibold">{{ $item->jadwalhalaqah ? ucFirst($item->jadwalhalaqah->nama_sesi):'Undefined' }}</span></p>
                            <p class="text-sm">Waktu Absen : <span class="font-semibold">{{ $item->waktu_absen }}</span></p>
                            <p class="text-sm">Kehadiran : <span class="font-semibold">{{ strtoupper($item->kehadiran) }}</span></p>
                            @if ($item->complainhalaqah)
                            <div>
                                <p class="text-sm font-semibold text-red-600">Ajuan Complain</p>
                                <p class="text-sm ">Permohonan Ubah Ke : <span class="font-semibold">{{ $item->complainhalaqah->change_to }}</span></p>
                                <p class="text-sm ">Catatan/Alasan :</p>
                                <p class="text-sm font-semibold">{{ $item->complainhalaqah->reason }}</p>
                                
                                @if ($item->complainhalaqah->status == 1)
                                <div class="flex items-center text-sm text-green-500">
                                    <svg class="w-3.5 h-3.5 me-2  flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                    </svg>
                                    {{ __('Complain Diterima') }}
                                </div>
                                @elseif ($item->complainhalaqah->status = 0)
                                <div class="flex items-center text-sm text-red-500">
                                    <svg class="w-3.5 h-3.5 me-2  flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('Ditolak') }}
                                </div>
                                @else
                                <div class="flex items-center text-sm text-orange-300">
                                    <svg class="w-3.5 h-3.5 me-2  flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('Belum diproses') }}
                                </div>
                                @endif

                            </div>
                            @endif
                        </div>
                        

                        @if ($item->kehadiran == 'alpa' && !$item->complainhalaqah && \Carbon\Carbon::parse($item->tanggal)->diffInDays($today) < 4)
                        <div>
                            <a href="{{ route('v2.complain.halaqah',$item) }}" class="inline-block p-2 text-sm text-white bg-red-800 rounded-lg hover:ring-2 hover:ring-red-300">Ajukan Complain</a>
                        </div>
                        @endif
                    </div>
                </div>
            </li>
        @empty
            <li class="">Tidak Ada Data yang Ditemukan</li>
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