<div  x-data="{absenOpen: 'pegawai'}">
    <div class="mb-4" >
        <x-admin-template>
            <div class="flex gap-4 divide-x divide-red-300">
                <div class="flex gap-4">
                    <div >
                        <x-input-label class="block mb-2 text-xs text-gray-500" for="startDate">{{ __('Tanggal Mulai') }}</x-input-label>
                        <x-text-input-tailwind type="date" wire:model.live='startDate' id="startData"></x-text-input-tailwind>
                    </div>
                    <div>
                        <x-input-label class="block mb-2 text-xs text-gray-500" for="endDate">{{ __('Tanggal Akhir') }}</x-input-label>
                        <x-text-input-tailwind  type="date"  wire:model.live='endDate' id="endDate"></x-text-input-tailwind>
                    </div>
                </div>
            </div>
        </x-admin-template>
    </div>

    <x-admin-template>
        <div class="mb-6 bg-white border-b border-gray-200 rounded-lg ">
            <ul class="flex flex-wrap gap-4 mb-4 text-sm font-medium text-center">
                <li class="me-2">
                    <button x-on:click="absenOpen = 'pegawai'" class="inline-block rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="absenOpen=='pegawai' ?'border-b-2 text-red-700 border-red-700':''"  type="button" >Karyawan</button>
                </li>
                <li class="me-2">
                    <button x-on:click="absenOpen = 'mengajar'" class="inline-block rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="absenOpen=='mengajar' ?'border-b-2 text-red-700 border-red-700':''" type="button">Mengajar</button>
                </li>
                <li class="me-2">
                    <button x-on:click="absenOpen = 'halaqah'" class="inline-block rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="absenOpen=='halaqah' ?'border-b-2 text-red-700 border-red-700':''" >Halaqah</button>
                </li>
            </ul>
        </div>

        @php
        $harikerja= $jumlahharikerja -$jumlahMinggu-$jumlahharilibur;
        @endphp
        
        <div class="relative overflow-x-auto" x-show="absenOpen == 'pegawai'">
            <div class="items-end justify-between px-4 mb-3 md:flex">
                <ul class="divide-y ">
                    <li class="py-1">
                        <p class="text-xs text-gray-500">Jumlah hari kerja = <span class="font-bold">{{ $jumlahharikerja -$jumlahMinggu-$jumlahharilibur }}</span></p>
                    </li>
                    <li class="py-1">
                        <p class="text-xs text-gray-500">Jumlah hari minggu = <span class="font-bold">{{ $jumlahMinggu }}</span></p>
                    </li>
                    <li class="pb-1">
                        <div class="flex items-center gap-4">
                            <label for="counter-input" class="mb-1 text-xs text-gray-500">Jumlah Hari Libur Selain Minggu:</label>
                            <div class="relative flex items-center">
                                <button type="button" wire:click="decrement"  class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                    <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" id="counter-input" wire:model.live='jumlahharilibur'  class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder=""  required />
                                <button type="button" wire:click="increment" class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                    <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
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
                            Masuk 1
                        </th>
                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                            Masuk 2
                        </th>
                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                            Pulang
                        </th>
                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                            Hari Hadir
                        </th>
                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                            Alpa
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $pegawai)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" x-data="{showPegawai{{ $pegawai['user_id'] }}:true}">
                        <td scope="row" class="items-center table-cell w-3 px-4 py-4 md:hidden">
                            <button x-on:click="showPegawai{{ $pegawai['user_id'] }} = !showPegawai{{ $pegawai['user_id'] }}">
                                <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="flex items-center justify-between">
                                <p>{{ $pegawai['user_name'] }}</p>
                                <div class="block md:hidden">
                                    <p class="text-red-600 ">{{ $harikerja-$pegawai['total_hadir'] }} <span class="text-[8px]">Alpa</span></p>
                                </div>
                            </div>
                            <div class="block md:hidden" x-show="showPegawai{{ $pegawai['user_id'] }}">
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Masuk 1</dt>
                                    <dt class="font-bold">{{ $pegawai['jumlah_scan_masuk1'] }}</dt>
                                </dl>
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Masuk 2</dt>
                                    <dt class="font-bold">{{ $pegawai['jumlah_scan_masuk2'] }}</dt>
                                </dl>
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Pulang</dt>
                                    <dt class="font-bold">{{ $pegawai['jumlah_scan_pulang'] }}</dt>
                                </dl>
                                <dl class="flex items-center gap-2">
                                    <dt class="text-xs text-gray-400">Hari Hadir</dt>
                                    <dt class="font-bold">{{ $pegawai['total_hadir'] }}</dt>
                                </dl>
                            </div>
                        </th>
                        <td class="hidden px-6 py-4 text-center md:table-cell">
                            <p>{{ $pegawai['jumlah_scan_masuk1'] }}</p>
                            <p class="text-[9px]">Terlambat : {{ $pegawai['terlambat_masuk1'] ." Menit" }}</p>
                        </td>
                        <td class="hidden px-6 py-2 text-center md:table-cell">
                           {{ $pegawai['jumlah_scan_masuk2'] }}
                           <p class="text-[9px]">Terlambat : {{ $pegawai['terlambat_masuk2'] ." Menit" }}</p>
                        </td>
                        <td class="hidden px-6 py-2 text-center md:table-cell">
                           {{ $pegawai['jumlah_scan_pulang'] }}
                        </td>
                        <td class="hidden px-6 py-2 text-center md:table-cell">
                           {{ $pegawai['total_hadir'] }}
                        </td>
                        <td class="hidden px-6 py-2 text-center text-red-600 md:table-cell">
                           {{ $harikerja-$pegawai['total_hadir'] }}
                           <p class="text-[9px]">Terlambat M1 + M2: {{ $pegawai['terlambat_masuk1'] + $pegawai['terlambat_masuk2'] ." Menit" }}</p>
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

        <div x-show="absenOpen == 'halaqah'">
            <livewire:new-admin.report.halaqah-report :startDate="$startDate" :endDate="$endDate"/>
        </div>

        <div class="relative overflow-x-auto" x-show="absenOpen == 'mengajar'">
            <livewire:new-admin.report.mengajar-report :startDate="$startDate" :endDate="$endDate"/>
        <div>
        



    </x-admin-template>
</div>

