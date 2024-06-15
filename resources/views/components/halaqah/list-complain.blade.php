@props(['models','showButton'=>false])
<ul class="max-w-lg divide-y">
    @forelse ($models as $item)
    <li class="relative pb-3 sm:pb-4" x-data="{showDetail{{ $item->id }}:false}" x-on:click.outside="showDetail{{ $item->id }} =false">
        <div class="flex items-start space-x-4 rtl:space-x-reverse">
            <div class="flex-shrink-0">
                <button x-on:click="showDetail{{ $item->id }} = !showDetail{{ $item->id }}">
                    <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 min-w-0 ">
                <p class="text-sm font-bold text-gray-900 truncate dark:text-white">
                    {{ ucWords($item->absenhalaqah->user->name) }}
                </p>
                <p class="mb-2 text-sm text-gray-500 truncate dark:text-gray-400">
                    Complain : <span class="font-medium text-gray-800">{{ ucWords($item->change_to) }}</span>
                </p>
                <div x-show="showDetail{{ $item->id }}" class="space-y ">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tanggal halaqah : <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($item->absenhalaqah->tanggal)->format('l, d-m-Y') }}</span>
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Sesi : <span class="font-medium text-gray-800">{{ucwords($item->absenhalaqah->jadwalhalaqah->nama_sesi) }}</span>
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Alasan : {{ $item->reason }}
                    </p>
                    @if ($showButton)
                    <div class="mt-2" >
                        <button class="btn-outline-primary" wire:click='denie({{ $item->id }})'>Tolak</button>
                        <button class="btn-primary" wire:click='approve({{ $item->id }})'>Terima</button>
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
</ul>