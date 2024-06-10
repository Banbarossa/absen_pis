<x-user-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    @role('admin|hrd')
    <div class="w-full pb-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <livewire:user.dashboard.widget-count-user>
            <livewire:user.dashboard.widget-count-absen-harian>
            <div class="hidden lg:block">
                <a href="#" class="relative flex items-center justify-center gap-4 p-4 bg-gray-200 border-2 border-white border-dashed rounded-lg shadow-md group min-h-28">
                    <div class="transition duration-500 group-hover:scale-125 group-hover:rotate-6">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>
                          
                    </div>
                </a>
            </div>
            <div class="hidden lg:block">
                <a href="#" class="relative flex items-center justify-center gap-4 p-4 bg-gray-200 border-2 border-white border-dashed rounded-lg shadow-md group min-h-28">
                    <div class="transition duration-500 group-hover:scale-125 group-hover:rotate-6">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>
                          
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endrole

    {{-- Scan Guru SD --}}
    <div>
        <livewire:user.scan-mengajar-pkkps.index>
    </div>
    {{-- Edn Scan Guru SD --}}

    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <div class="md:col-span-4 lg:col-span-3">
            <div x-data="{tab:'karyawan'}">
                <div class="mb-4 bg-white border-b border-gray-200 rounded-lg dark:border-gray-700">
                    <div class="px-6 pt-6 text-sm">
                        Riwayat Absen
                    </div>
                    <ul class="flex flex-wrap px-4 mb-4 text-sm font-medium text-center">
                        <li class="me-2">
                            <button x-on:click="tab = 'karyawan'" class="inline-block p-2 rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="tab=='karyawan' ?'border-b-2 text-red-700 border-red-700':''"  type="button" >Karyawan</button>
                        </li>
                        <li class="me-2">
                            <button x-on:click="tab = 'mengajar'" class="inline-block p-2 rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="tab=='mengajar' ?'border-b-2 text-red-700 border-red-700':''" type="button">Mengajar</button>
                        </li>
                        @role('musyrif halaqah')
                        <li class="me-2">
                            <button x-on:click="tab = 'halaqah'" class="inline-block p-2 rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="tab=='halaqah' ?'border-b-2 text-red-700 border-red-700':''" >Halaqah</button>
                        </li>
                        @endrole
                    </ul>
                </div>
                <div>
                    <div class="w-full p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" x-show="tab == 'karyawan'">
                        <livewire:user.dashboard.karyawan>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" x-show="tab == 'mengajar'">
                        <livewire:user.dashboard.latest-absen-mengajar>
                    </div>
                    @role('musyrif halaqah')
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" x-show="tab == 'halaqah'">
                        <livewire:user.dashboard.latest-absen-halaqah>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
        <div class="hidden lg:col-span-1 lg:block">
            <div class="p-6 bg-white rounded-lg">
                <x-jam-absen>
                </x-jam-absen>
            </div>
        </div>
    </div>


</x-user-layout>
