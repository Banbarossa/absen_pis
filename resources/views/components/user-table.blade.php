
@props(['users'])

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase md:text-sm bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="table-cell px-6 py-3 md:hidden">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Email
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Password Absen
                </th>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Status
                </th>
            </tr>
                <th scope="col" class="hidden px-6 py-3 md:table-cell">
                    Action
                </th>
            </tr>
        </thead>
        <tbody x-data={open:null}>
            @forelse ($users as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td scope="row" class="table-cell w-4 px-4 py-4 md:hidden">
                    <button x-on:click="open = open === {{ $item->id }} ? null : {{ $item->id }}">
                        <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </button>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <p>{{ strtoupper($item->name) }}</p>
                    <p>{{ $item->email }}</p>
                    <div class="block mt-3 space-y-2 md:hidden" x-show="open === {{ $item->id }}" x-on:click.outside="open = null">
                        <dl>
                            <dt class="text-xs text-gray-400">Password Absen</dt>
                            <dt>{{ $item->password_absen }}</dt>
                        </dl>
                    </div>
                </th>
                <td class="hidden px-6 py-4 md:table-cell">
                    {{ $item->email }}
                </td>
                <td class="hidden px-6 py-2 md:table-cell">
                    <div class="relative inline-block">
                        <input type="text" id="textTarget" class="block px-2 py-2 text-sm font-semibold text-gray-600 border border-gray-300 rounded-lg bg-gray-50 " value="{{ $item->password_absen }}" readonly disabled/>
                        <button type="button"  onclick="copyText()" class="absolute inset-y-0 flex items-center end-0 pe-3">
                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="hidden px-6 py-4 md:table-cell">
                    <label class="inline-flex items-center cursor-pointer me-5">
                        <input type="checkbox" wire:click='changeStatus({{ $item->id }})' value="" class="sr-only peer" {{ $item->status ?'checked' :''  }} wire:key='{{ $item->id }}'>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                    </label>
                </td>
                <td class="hidden px-6 py-4 md:table-cell">
                    <a href="{{ route('v2.akun.update',$item) }}" class="p-2 border border-red-500 rounded-lg hover:ring-2 hover:ring-red-200">Edit</a>
                </td>
            </tr>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ __('Tidak ada data yang ditemukan') }}
                    </td>
                </tr>
            @endforelse
        
        </tbody>
    </table>
</div>