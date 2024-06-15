<div class="grid grid-cols-1 gap-4 lg:grid-cols-3" x-data="{ popuphalaqah: false, imageUrl: '' }">
    <div class="hidden lg:block">
        <x-admin-template>
            {!! $chart->container() !!}
        </x-admin-template>
    </div>
    <div class="lg:col-span-2">
        <x-admin-template>
            <div class="justify-between md:flex">
                <div>
                    <p class="text-sm text-gray-600">Kehadiran Halaqah</p>
                    <h3 class="text-lg font-semibold">{{ $user->name }}</h3>

                </div>
                <div class="flex items-center gap-4">
                    <x-text-input-tailwind wire:model.live='startDate' type="date"></x-text-input-tailwind>
                    <x-text-input-tailwind wire:model.live='endDate' type="date"></x-text-input-tailwind>
                </div>

            </div>
        </x-admin-template>
        <ul class="mt-4">
            @forelse ($absen as $item)
            <li class="p-4 mb-4  rounded-lg sm:pb-4 {{ $item->kehadiran =='alpa' ?'bg-red-200' :'bg-white' }}">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                   <div class="flex-shrink-0">
                    @if ($item->image)
                    <a href="javascript:void(0)" x-on:click="popuphalaqah = true; imageUrl = '{{ asset('storage/public/images/' . $item->image) }}'">
                        <img class="w-8 h-8 rounded-full" src="{{asset('storage/public/images/'.$item->image)}}" alt="Gambar">
                    </a>
                    @else
                    <img class="w-8 h-8 rounded-full" src="{{asset('assets/images/avatar.png')}}" alt="Gambar">
                    @endif
                   </div>
                   <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                         {{ \Carbon\Carbon::parse($item->tanggal)->format('l, d M Y') }}
                         <span class="text-xs text-gray-500">{{ $item->waktu_absen }}</span>
                      </p>
                      <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                         {{ $item->jadwalhalaqah ? $item->jadwalhalaqah->nama_sesi :'' }}
                      </p>
                      @if ($item->latitude && $item->longitude)
                      <a href="https://www.google.com/maps?q={{ $item->latitude.','.$item->longitude }}" target="_blank" class="text-sm text-blue-700 hover:underline hover:underline-offset-1">Lihat Lokasi</a>
                      @endif
                   </div>
                   <div class="inline-flex items-center text-base font-semibold {{ $item->kehadiran =='alpa' ?'text-red-700' :'text-gray-900' }}">
                      {{ ucWords($item->kehadiran) }}
                   </div>
                </div>
             </li>
            @empty
                <li class="p-4 mb-4 bg-white rounded-lg sm:pb-4">
                    <p class="text-sm">Tidak ada data yang ditemukan</p>
                </li>
            @endforelse
        </ul>
    </div>

    {{-- popup --}}
    <div x-show="popuphalaqah" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-50 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500 bg-opacity-50">
        <div class="relative w-full max-w-lg max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" @click.outside="popuphalaqah = false">
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-white">
                        Gambar
                    </h3>
                    <button type="button" x-on:click="popuphalaqah = false" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
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
                        x-on:click="popuphalaqah = false"
                        type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close
                    </button>
                </div>
            </div>
        </div>
    </div>






    @push('script')
    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}
    @endpush
</div>
