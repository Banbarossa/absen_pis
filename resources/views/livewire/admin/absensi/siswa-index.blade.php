<x-admin-template>
    <div class="flex items-end mb-4">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 grow">
            <div class="w-full col-span-2 md:w-auto md:col-span-1">
                <label for="kelas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                <select id="kelas" wire:model.live='kelas_id' class="block p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-red-200 focus:border-red-500 w-full">
                    <option selected>Pilih Kelas</option>
                    @foreach ($rombel as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_rombel }}</option>
                    @endforeach
                </select>
            </div>
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
                    <th scope="col" class="px-6 py-3">
                        <p class="block md:hidden">Absensi</p>
                        <p class="hidden md:block">Nama Rombel</p>
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Nama
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Hadir
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Izin
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Sakit
                    </th>
                    <th scope="col" class="hidden px-6 py-3 md:table-cell">
                        Alpa
                    </th>
                </tr>
            </thead>
            <tbody x-data={open:null}>
                @forelse ($absensiswa as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="{{ route('v2.laporan.detail-absen-siswa',$item->student_id) }}">
                            <div class="flex items-end justify-between">
                                <p class="inline-block md:hidden">{{ ucFirst($item->name) }}</p>
                                <p class="text-[8px] md:text-sm">{{ ucFirst($item->nama_rombel) }}</p>
                            </div>
                        </a>
                        <div class="grid grid-cols-4 mt-2 text-xs md:hidden">
                            <div>
                                <p class="text-[10px] text-green-700">Hadir</p>
                                <p class="font-bold">{{ $item->total_jam_h .' Jp'}} </p>
                            </div>
                            <div>
                                <p class="text-[10px] text-orange-700">Izin</p>
                                <p class="font-bold">{{ $item->total_jam_i .' Jp'}} </p>
                            </div>
                            <div>
                                <p class="text-[10px] text-blue-700">Sakit</p>
                                <p class="font-bold">{{ $item->total_jam_s .' Jp'}} </p>
                            </div>
                            <div>
                                <p class="text-[10px] text-red-700">Alpa</p>
                                <p class="font-bold">{{ $item->total_jam_a .' Jp'}} </p>
                            </div>
                        </div>
                    </th>
                    <td class="hidden px-6 py-4 md:table-cell">
                        <a href="{{ route('v2.laporan.detail-absen-siswa',$item->student_id) }}">
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ $item->total_jam_h }}
                    </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ $item->total_jam_i }}
                    </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ $item->total_jam_s }}
                    </td>
                    <td class="hidden px-6 py-2 md:table-cell">
                       {{ $item->total_jam_a }}
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