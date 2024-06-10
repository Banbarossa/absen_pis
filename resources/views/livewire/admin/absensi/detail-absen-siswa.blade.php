<x-admin-template>
    <div class="mb-4">
        <p class="text-lg">Absensi Kehadiran <span class="font-bold text-red-700">{{ $studentName }}</span></p>
    </div>
    <div class="flex items-end mb-4">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 grow">
            <div>
                <x-input-label class="mb-2 text-sm" for="startDate">{{ __('Tanggal Mulai') }}</x-input-label>
                <x-text-input-tailwind id="startDate" type="date" wire:model.live='startDate' class="p-2 text-sm"></x-text-input-tailwind>
            </div>
            <div>
                <x-input-label class="mb-2 text-sm" for="endDate">{{ __('Tanggal Akhir') }}</x-input-label>
                <x-text-input-tailwind id="endDate" type="date" wire:model.live='endDate' class="p-2 text-sm"></x-text-input-tailwind>
            </div>
        </div>
        <div class="relative hidden md:inline-block" x-data="{dropdown:false}" x-on:click.outside="dropdown = false">
            <button x-on:click="dropdown = !dropdown" class="inline-flex items-center justify-end w-10 text-sm font-medium text-gray-900 bg-white " type="button">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                </svg>
            </button>
                
                <!-- Dropdown menu -->
            <div x-show="dropdown" class="absolute right-0 z-10 w-auto origin-top-right bg-gray-400 divide-y divide-gray-100 rounded-lg shadow -bottom-10">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                    <li>
                        <a href="javascript:void()" class="block px-4 text-xs text-white dark:hover:bg-gray-600 dark:hover:text-white md:text-sm text-nowrap" wire:click='unduhExcel'>Unduh Excel <span wire:loading class="animate-pulse">...</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 md:text-sm dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Tanggal
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Nama Guru
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Pelajaran
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Jam Ke
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Status Kehadiran
                    </th>
                </tr>
            </thead>
            <tbody x-data={open:null}>
                @forelse ($absens as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <p class="text-sm font-bold text-red-700">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                        <div class="flex items-end justify-between">
                            <div class="block md:hidden">
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Guru</dt>
                                    <dt class="font-bold text-gray-500">{{ $item->absensekolah ?  $item->absensekolah->user->name :'undefined' }}</dt>
                                </dl>
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Mata Pelajaran</dt>
                                    <dt class="font-bold text-gray-500">{{ $item->absensekolah->mapel ?  ucFirst($item->absensekolah->mapel->mata_pelajaran) :'undefined' }}</dt>
                                </dl>
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Jam Ke</dt>
                                    <dt class="font-bold text-gray-500">{{ $item->absensekolah ? $item->absensekolah->jam_ke :''}}</dt>
                                </dl>
                            </div>
                            <div class="flex items-center justify-center w-10 h-10 p-1 text-lg border-2 rounded-lg md:hidden {{ $item->status == 'h' ? 'text-green-600 border-green-600':'text-red-500 border-red-500' }}">{{ ucWords($item->status) }}</div>
                        </div>
                    </th>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ $item->absensekolah ?  $item->absensekolah->user->name :'undefined' }}
                    </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ $item->absensekolah->mapel ?  ucFirst($item->absensekolah->mapel->mata_pelajaran) :'undefined' }}
                    </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                        {{ $item->absensekolah ? $item->absensekolah->jam_ke :''}}
                     </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ ucWords($item->status) }}
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4" colspan="7">{{ __('Tidak ada data yang ditemukan') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-template>