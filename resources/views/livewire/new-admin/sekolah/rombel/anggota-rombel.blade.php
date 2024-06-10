    <x-admin-template>
        
        <div  class="mb-6 text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <div>
                <div class="flex items-center justify-between gap-2 mb-4">
                    <x-text-input-tailwind wire:model.live='search' placeholder='Type to search....' class="w-full md:w-1/2 lg:w-1/3"></x-text-input-tailwind>
                    <div class="relative flex items-center gap-2" x-data="{dropdown:false}" x-on:click.outside="dropdown = false">
                        <button data-modal-target="extralarge-modal" data-modal-toggle="extralarge-modal" class="block w-full px-5 py-2 text-sm font-medium text-center border border-red-400 rounded-lg text-red md:w-auto hover:ring-2 hover:ring-red-300 focus:ring-2 focus:outline-none focus:ring-red-300"  type="button">
                            Tambah Siswa
                        </button>
                        <button x-on:click="dropdown = !dropdown" class="inline-flex items-center text-sm font-medium text-gray-900 bg-white " type="button">
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
                                <th scope="col" class="table-cell px-6 py-3 md:hidden">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                    NISN
                                </th>
                                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                    NIS
                                </th>
                                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                    Akses Absen
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data={open:null}>
                            @forelse ($anggotakelas as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" class="items-center table-cell w-3 px-4 py-4 md:hidden">
                                    <button x-on:click="open = open === {{ $item->anggota_kelas_id }} ? null : {{ $item->anggota_kelas_id }}">
                                        <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex justify-between">
                                        <div>
                                            <p>{{ strtoupper($item->student->name) }}</p>
                                        </div>
                                        <div class="inline-block md:hidden">20</div>
                                    </div>
                                    <div class="block md:hidden" x-show="open === {{ $item->anggota_kelas_id }}" x-on:click.outside="open = null">
                                        <dl class="flex items-center gap-2">
                                            <dt class="text-xs text-gray-400">NISN</dt>
                                            <dt class="font-bold">{{ $item->student->nisn}}</dt>
                                        </dl>
                                        <dl class="flex items-center gap-2">
                                            <dt class="text-xs text-gray-400">NIS</dt>
                                            <dt class="font-bold">{{ $item->student->nis }}</dt>
                                        </dl>
                                    </div>
                                </th>
                                <td class="hidden px-6 py-4 md:table-cell">
                                    {{ $item->nisn }}
                                </td>
                                <td class="hidden px-6 py-2 md:table-cell">
                                    {{ $item->nis }}
                                </td>
                                <td class="hidden px-6 py-4 md:table-cell">
                                    <button wire:click='hapusAnggotaRombel({{ $item->anggota_kelas_id }})' wire:key='{{ $item->id }}'>Hapus</button>
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
            </div>
        </div>


        

        <!-- Modal toggle -->
        
        
        <div id="extralarge-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full" wire:ignore.self>
            <div class="relative w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                            Tambah Siswa ke Rombel
                        </h3>
                        <button  type="button" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="extralarge-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 space-y-4 md:p-5">
                        
                        <div class="relative p-6 overflow-y-auto h-80">
                            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-200 md:text-sm dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nama
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                            NISN
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                            NIS
                                        </th>
                                        <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody x-data={open:null}>
                                    @forelse ($students as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <p>{{ strtoupper($item->name) }}</p>
                                        </th>
                                        <td class="px-6 py-4 ">
                                            {{ $item->nisn }}
                                        </td>
                                        <td class="px-6 py-2 ">
                                            {{ $item->nis }}
                                        </td>
                                        <td class="px-6 py-2">
                                            <button wire:click='addStudenToRombel({{ $item->id }})' wire:key='{{ $item->id }}'>Tambah </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4">{{ __('Tidak ada data yang ditemukan') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex items-center p-4 space-x-3 border-t border-gray-200 rounded-b md:p-5 rtl:space-x-reverse dark:border-gray-600">
                        <button  data-modal-hide="extralarge-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                    </div>
                </div>
            </div>
        </div>
        


    </x-admin-template>
