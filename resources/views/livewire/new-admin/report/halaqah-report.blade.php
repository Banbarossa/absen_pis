<div>
    <div class="justify-end px-3 mb-3 md:flex">

        <div class="relative text-end" x-data="{dropdown:false}" x-on:click.outside="dropdown = false">
            <a href="" class="inline-block mr-3 text-sm rounded-t-lg hover:border-b-2 hover:text-red-700 hover:border-red-600 ">Lihat Detail</a>
            <button x-on:click="dropdown = !dropdown" class="inline-flex items-center text-sm font-medium text-gray-900 bg-white " type="button">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                </svg>
            </button>
                
            <div x-show="dropdown" class="absolute right-0 z-10 w-auto origin-top-right bg-gray-400 divide-y divide-gray-100 rounded-lg shadow -bottom-10">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                    <li>
                        <a href="javascript:void()" class="block px-4 text-xs text-white dark:hover:bg-gray-600 dark:hover:text-white md:text-sm text-nowrap" wire:click='unduhExcel'>Unduh Excel <span wire:loading class="animate-pulse">...</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200 md:text-sm dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="table-cell px-6 py-3 md:hidden">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Hadir
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Izin Dinas (TP)
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Izin Pribadi (TP)
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Sakit (TP)
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Alpa (TP)
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absenHalaqah as $halaqah)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" x-data="{showPegawai{{ $halaqah['user_id'] }}:true}">
                <td scope="row" class="items-center table-cell w-3 px-4 py-4 md:hidden">

                    <button x-on:click="showPegawai{{ $halaqah['user_id'] }} = !showPegawai{{ $halaqah['user_id'] }}">
                        <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </button>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="flex items-center justify-between">
                        <p>{{ $halaqah['nama'] }}</p>
                    </div>
                    <div class="block md:hidden" x-show="showPegawai{{ $halaqah['user_id'] }}">
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Hadir</dt>
                            <dt class="font-bold">{{ $halaqah['hadir'] }} <span class="text-[8px]">Tatap Muka</span></dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Izin Dinas</dt>
                            <dt class="font-bold">{{ $halaqah['izin_dinas'] }} <span class="text-[8px]">Tatap Muka</span></dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Izin Pribadi</dt>
                            <dt class="font-bold">{{ $halaqah['izin_pribadi'] }} <span class="text-[8px]">Tatap Muka</span></dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Sakit</dt>
                            <dt class="font-bold">{{ $halaqah['sakit'] }} <span class="text-[8px]">Tatap Muka</span></dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Alpa</dt>
                            <dt class="font-bold">{{ $halaqah['alpa'] }} <span class="text-[8px]">Tatap Muka</span></dt>
                        </dl>
                    </div>
                </th>
                <td class="hidden px-6 py-4 text-center md:table-cell">
                    <p>{{ $halaqah['hadir'] == 0 ?'':$halaqah['hadir'] }}</p>
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $halaqah['izin_dinas'] == 0 ?'':$halaqah['izin_dinas'] }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $halaqah['izin_pribadi'] == 0 ?'':$halaqah['izin_pribadi'] }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $halaqah['sakit'] == 0 ?'':$halaqah['sakit'] }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $halaqah['alpa'] == 0 ?'':$halaqah['alpa'] }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4">{{ __('Tidak ada data yang ditemukan') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
