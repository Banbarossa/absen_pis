<div>
    <div class="justify-between px-3 mb-3 md:flex">
        <div class="flex py-2">
            <div class="flex items-center me-4">
                <input id="semua" type="radio" value="" name="sekolah_id" wire:model.live='sekolah_id' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="semua" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Semua Jenjang</label>
            </div>
            @foreach ($sekolahs as $item)
            <div class="flex items-center me-4">
                <input id="sekolah{{ $item->id }}" type="radio" wire:model.live='sekolah_id' value="{{ $item->id }}" name="sekolah_id" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="sekolah{{ $item->id }}" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">{{ strtoupper($item->jenjang) }}</label>
            </div>
            @endforeach
        </div>

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
                    Izin Dinas
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Izin Pribadi
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Sakit
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Alpa
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Jumlah Hari
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensekolah as $sekolah)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" x-data="{showPegawai{{ $sekolah->user_id }}:true}">
                <td scope="row" class="items-center table-cell w-3 px-4 py-4 md:hidden">
                    <button x-on:click="showPegawai{{ $sekolah->user_id }} = !showPegawai{{ $sekolah->user_id }}">
                        <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </button>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="flex items-center justify-between">
                        <p>{{ $sekolah->user_name }}</p>
                        {{-- <div class="block md:hidden">
                            <p class="text-red-600 ">{{ $harikerja-$sekolah->total_hadir }} <span class="text-[8px]">Alpa</span></p>
                        </div> --}}
                    </div>
                    {{-- <div class="block md:hidden" x-show="showPegawai{{ $sekolah->id }}">
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Masuk 1</dt>
                            <dt class="font-bold">{{ $sekolah->jumlah_scan_masuk1 }}</dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Masuk 2</dt>
                            <dt class="font-bold">{{ $sekolah->jumlah_scan_masuk2 }}</dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Pulang</dt>
                            <dt class="font-bold">{{ $sekolah->jumlah_scan_pulang }}</dt>
                        </dl>
                        <dl class="flex items-center gap-2">
                            <dt class="text-xs text-gray-400">Hari Hadir</dt>
                            <dt class="font-bold">{{ $sekolah->total_hadir }}</dt>
                        </dl> --}}
                    </div>
                </th>
                <td class="hidden px-6 py-4 text-center md:table-cell">
                    <p>{{ $sekolah->jam_hadir == 0 ?'':$sekolah->jam_hadir}}</p>
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $sekolah->jam_izindinas == 0 ?'':$sekolah->jam_izindinas }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $sekolah->jam_izinpribadi == 0 ?'':$sekolah->jam_izinpribadi }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $sekolah->jam_sakit == 0 ?'':$sekolah->jam_sakit }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $sekolah->jam_alpa == 0 ?'':$sekolah->jam_alpa }}
                </td>
                <td class="hidden px-6 py-2 text-center md:table-cell">
                   {{ $sekolah->jumlah_hari_hadir == 0 ?'':$sekolah->jumlah_hari_hadir }}
                </td>
            </tr>
            @empty
            <tr>
                <td class="px-6 py-4">{{ __('Tidak ada data yang ditemukan') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
