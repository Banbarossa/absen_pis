<x-admin-template>
    <div  class="mb-6 text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <div>
            <div class="flex items-center justify-between gap-2 mb-4">
                <x-text-input-tailwind wire:model.live='search' placeholder='Type to search....' class="w-full md:w-1/2 lg:w-1/3"></x-text-input-tailwind>
                <div class="relative flex items-center gap-2" x-data="{dropdown:false}" x-on:click.outside="dropdown = false">
                    <a href="{{ route('v2.halaqah.create') }}" class="hidden w-full px-5 py-2 text-sm font-medium text-center border border-red-400 rounded-lg md:block text-red md:w-auto hover:ring-2 hover:ring-red-300 focus:ring-2 focus:outline-none focus:ring-red-300">Tambah Halaqah</a>
                    <button x-on:click="dropdown = !dropdown" class="inline-flex items-center text-sm font-medium text-gray-900 bg-white md:hidden " type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                        
                    <div x-show="dropdown" class="absolute right-0 z-10 w-auto origin-top-right bg-gray-400 divide-y divide-gray-100 rounded-lg shadow -bottom-10">
                        <ul class="py-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                            <li>
                                <a href="{{ route('v2.halaqah.create') }}" class="block px-4 text-xs text-white md:hidden dark:hover:bg-gray-600 dark:hover:text-white md:text-sm text-nowrap"> Tambah</a>
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
                                Nama halaqah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Santri
                            </th>
                            <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                Status
                            </th>
                            <th scope="col" class="hidden px-6 py-3 md:table-cell">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody x-data={open:null}>
                        @forelse ($halaqah as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex justify-between">
                                        <p>{{ strtoupper($item->nama_halaqah) }}</p>
                                        <a href="{{ route('v2.halaqah.update',$item) }}" class="md:hidden">
                                            <svg class="w-4 h-4" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                              </svg>
                                        </a>
                                    </div>
                                    <p class="text-gray-500">Musyrif: {{ ucWords($item->user ? $item->user->name :'') }}</p>
                                </div>
                            </th>
                            <td class="hidden px-6 py-4 md:table-cell">
                                <a href="{{ route('v2.anggota-halaqah',$item) }}" class="inline-flex p-2 border border-red-500 rounded-lg hover:ring-2 hover:ring-red-200">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                                        </svg>
                                        {{ $item->jumlah_anggota }}
                                        <span class="text-[8px]">Siswa</span>

                                    </div>
                                </a>
                            </td>
                            <td class="hidden px-6 py-4 md:table-cell">
                                <label class="inline-flex items-center cursor-pointer me-5">
                                    <input type="checkbox" wire:click='changeStatus({{ $item->id }})' value="" class="sr-only peer" {{ $item->status ?'checked' :''  }}>
                                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                </label>
                            </td>
                            <td class="hidden px-6 py-4 md:table-cell">
                                <a href="{{ route('v2.halaqah.update',$item) }}" class="hidden px-5 py-2 text-sm font-medium text-center border border-red-400 rounded-lg md:block text-red md:w-auto hover:ring-2 hover:ring-red-300 focus:ring-2 focus:outline-none focus:ring-red-300">Edit</a>
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
</div>

</x-admin-template>
