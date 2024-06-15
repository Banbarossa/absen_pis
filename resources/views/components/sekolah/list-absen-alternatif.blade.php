@props(['models','showButton'=>false])
<ul class="max-w-xl divide-y" x-data="{ popuppegawai: false, imageUrl: '' }">
    @forelse ($models as $item)
    <li class="relative py-2 sm:pb-4" x-data="{showDetail{{ $item->id }}:false}" x-on:click.outside="showDetail{{ $item->id }} =false">
        <div class="flex items-start space-x-4 rtl:space-x-reverse">
            <div class="flex gap-3">
                <button x-on:click="showDetail{{ $item->id }} = !showDetail{{ $item->id }}">
                    <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </button>
                <div>
                    @if ($item->image)
                    <a href="javascript:void(0)" x-on:click="popuppegawai = true; imageUrl = '{{ asset('storage/public/images/' . $item->image) }}'">
                        <img src="{{ asset('storage/public/images/' . $item->image) }}" class="w-20 h-20 transition duration-500 rounded-xl min-w-20 hover:scale-125" alt="">
                    </a>
                    @else
                    <a href="javascript:void(0)" x-on:click="popuppegawai = true; imageUrl = '{{ asset('assets/images/avatar.png') }}'">
                        <img src="{{ asset('assets/images/avatar.png') }}" class="w-20 h-20 rounded-xl" alt="">
                    </a>
                    @endif

                </div>
            </div>

            <div class="flex-1 min-w-0 ">
                <p class="text-sm font-bold text-gray-900 truncate dark:text-white">
                    {{ ucWords($item->user->name) }}
                </p>
                <p class="mb-2 text-sm text-gray-500 truncate dark:text-gray-400">
                    Hari/Tanggal dan jam Ke: <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d-m-Y') }} </span>
                </p>
                <div x-show="showDetail{{ $item->id }}" class="space-y ">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Kelas: <span class="font-medium text-gray-800">{{ $item->rombel->nama_rombel }}</span>
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Alasan : {{ $item->alasan }}
                    </p>
                    @if (!is_null($item->approved_by))
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Diverifikasi oleh : {{ $item->approvedBy->name }}
                    </p>
                    @endif
                    @if (!is_null($item->alasan_penolakan))
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Alasan Ditolak Admin: {{ $item->alasan_penolakan }}
                    </p>
                    @endif
                    @if ($showButton)
                    <div class="mt-2" >
                        <button class="btn-outline-primary me-8" wire:confirm='Apakah yakin menghapus data' wire:click='destroy({{ $item->id }})' x-on:click="showDetail{{ $item->id }} = false">
                            Hapus ??
                        </button>

                        <button class="btn-outline-primary" wire:click='denie({{ $item->id }})' x-on:click="showDetail{{ $item->id }} = false">
                            Tolak <span wire:loading wire:target='denie'>...</span>
                        </button>
                        <button class="btn-primary" wire:click='approve({{ $item->id }})' x-on:click="showDetail{{ $item->id }} = false">
                            Terima
                            <span wire:loading wire:target='approve'>...</span>
                        </button>
                        
                    </div>
                    @endif
                </div>
            </div>
            <div class="inline-flex items-center text-[10px] text-gray-500">
                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
            </div>
            
        </div>
     </li>
    @empty
    <li class="py-2 text-sm">Tidak ada Data Yang ditemukan</li>
    @endforelse


    {{-- PopUp --}}
    <div x-show="popuppegawai" class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-50 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500 bg-opacity-50">
        <div class="relative w-full max-w-lg max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" @click.outside="popuppegawai = false">
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-white">
                        Gambar
                    </h3>
                    <button type="button" x-on:click="popuppegawai = false" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
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
                        x-on:click="popuppegawai = false"
                        type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</ul>
