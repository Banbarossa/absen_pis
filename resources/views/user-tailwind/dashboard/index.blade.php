<x-user-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>


    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <div class="md:col-span-4 lg:col-span-3">
            <div x-data="{tab:'karyawan'}">
                <div class="mb-4 bg-white border-b border-gray-200 rounded-lg dark:border-gray-700">
                    <ul class="flex flex-wrap p-4 -mb-px text-sm font-medium text-center">
                        <li class="me-2">
                            <button x-on:click="tab = 'karyawan'" class="inline-block p-2 rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="tab=='karyawan' ?'border-b-2 text-red-700 border-red-700':''"  type="button" >Absen Karyawan</button>
                        </li>
                        <li class="me-2">
                            <button x-on:click="tab = 'mengajar'" class="inline-block p-2 rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="tab=='mengajar' ?'border-b-2 text-red-700 border-red-700':''" type="button">Absen Mengajar</button>
                        </li>
                        <li class="me-2">
                            <button x-on:click="tab = 'halaqah'" class="inline-block p-2 rounded-t-lg hover:border-b-2 hover:text-red-600 hover:border-red-300 dark:hover:text-gray-300" :class="tab=='halaqah' ?'border-b-2 text-red-700 border-red-700':''" >Absen Halaqah</button>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="w-full p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" x-show="tab == 'karyawan'">
                        <livewire:user.dashboard.karyawan>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" x-show="tab == 'mengajar'">
                        <livewire:user.dashboard.latest-absen-mengajar>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" x-show="tab == 'halaqah'">
                        <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                    </div>
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
