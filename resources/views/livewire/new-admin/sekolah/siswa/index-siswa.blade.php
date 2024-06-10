<div>
    <x-admin-template>
        <div  class="mb-6 text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <div>
                <div class="flex items-center justify-between gap-2 mb-4">
                    <x-text-input-tailwind wire:model.live='search' placeholder='type to search....' class="w-full md:w-1/2 lg:w-1/3"></x-text-input-tailwind>
                    <div class="relative" x-data="{dropdown:false}" x-on:click.outside="dropdown = false">
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
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody x-data={open:null}>
                            @forelse ($students as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" class="items-center table-cell w-3 px-4 py-4 md:hidden">
                                    <button x-on:click="open = open === {{ $item->id }} ? null : {{ $item->id }}">
                                        <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center justify-between">
                                        <p>{{ strtoupper($item->name) }}</p>
                                    </div>
                                    <div class="block md:hidden" x-show="open === {{ $item->id }}" x-on:click.outside="open = null">
                                        <dl class="flex items-center gap-2">
                                            <dt class="text-xs text-gray-400">Nis</dt>
                                            <dt class="font-bold">{{ $item->nis }}</dt>
                                        </dl>
                                        <dl class="flex items-center gap-2">
                                            <dt class="text-xs text-gray-400">NISN</dt>
                                            <dt class="font-bold">{{ $item->nisn }}</dt>
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
                                    <label class="inline-flex items-center cursor-pointer me-5">
                                        <input type="checkbox" wire:click='changeStatus({{ $item->id }})' value="" class="sr-only peer" {{ $item->status ?'checked' :''  }} wire:key='{{ $item->id }}'>
                                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                    </label>
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
                {{ $students->links() }}
            </div>
        </div>

    </x-admin-template>
</div>
