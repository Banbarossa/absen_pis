<aside class="px-2 py-4 bg-white divide-y-2 md:fixed md:top-20 md:min-w-60 md:w-60 rounded-xl md:bg-transparent">
    <ul class="grid grid-cols-3 gap-2 text-xs font-medium md:gap-1 md:grid-cols-1">

        <x-sidebar-link :href="route('v2.dashboard')" :active="Request::routeIs('v2.dashboard')" label="Dashboard">
            <svg class="w-5 h-5 transition duration-1000 group-hover:rotate-180"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 22 21">
                    <path
                        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                    <path
                        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
            </svg>
        </x-sidebar-link>
        
        {{-- Menu Hanya Tampil di Dashboard --}}
        @if (Request::routeis('v2.dashboard') || Request::is('v2/*'))
        <x-sidebar-link :href="route('v2.jadwal.mengajar')" :active="Request::routeIs('v2.jadwal.mengajar')" label="Jadwal Mengajar">
            <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 18 18">
                    <path
                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
            </svg>
        </x-sidebar-link>
        <x-sidebar-link :href="route('v2.jadwal.halaqah')" :active="Request::routeIs('v2.jadwal.halaqah')" label="Jadwal Halaqah">
            <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M15 4H9v16h6V4Zm2 16h3a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3v16ZM4 4h3v16H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" clip-rule="evenodd"/>
            </svg>
        </x-sidebar-link>
        @endif


        <ul class="hidden md:block">
            <li x-data="{ user: {{ Request::is('v2/admin/user') || Request::is('v2/admin/user/*') ? 'true' : 'false' }} }" >
                <x-sidebar-dropdown x-on:click="user = !user" :active="Request::is('v2/admin/user') || Request::is('v2/admin/user/*')" data="user" label='User - Role'>
                    @slot('svg')
                    <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                      </svg>
                      
                    @endslot
                     <x-sidebar-dropdown-link :href="route('v2.akun')" :active="Request::routeIs('v2.akun')">User</x-sidebar-dropdown-link>
                </x-sidebar-dropdown>
             </li>

        </ul>
        <ul class="hidden md:block">
            <li x-data="{ halaqah: {{ Request::is('v2/admin/halaqah') || Request::is('v2/admin/halaqah/*') ? 'true' : 'false' }} }">
                <x-sidebar-dropdown x-on:click="halaqah = !halaqah" :active="Request::is('v2/admin/halaqah') || Request::is('v2/admin/halaqah/*')" data="halaqah" label='halaqah'>
                    @slot('svg')

                    <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z"/>
                    </svg>
                    @endslot
                    <x-sidebar-dropdown-link :href="route('v2.halaqah')" :active="Request::routeIs('v2.halaqah')">Halaqah</x-sidebar-dropdown-link>
                    <x-sidebar-dropdown-link :href="route('v2.complain-absen-halaqah')" :active="Request::routeIs('v2.complain-absen-halaqah')">Complain Absen</x-sidebar-dropdown-link>
                    <x-sidebar-dropdown-link :href="route('v2.rekap-kehadiran-halaqah')" :active="Request::routeIs('v2.rekap-kehadiran-halaqah')">Kehadiran Musyrif</x-sidebar-dropdown-link>
                </x-sidebar-dropdown>
             </li>

        </ul>
        <ul class="hidden md:block">
            <li x-data="{ sekolah: {{ Request::is('v2/admin/sekolah') || Request::is('v2/admin/sekolah/*') ? 'true' : 'false' }} }">
                <x-sidebar-dropdown x-on:click="sekolah = !sekolah" :active="Request::is('v2/admin/sekolah') || Request::is('v2/admin/sekolah/*')" data="sekolah" label='Sekolah'>
                    @slot('svg')

                    <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z"/>
                    </svg>
                      
                    @endslot
                    <x-sidebar-dropdown-link :href="route('v2.rombel')" :active="Request::routeIs('v2.rombel')">Kelas</x-sidebar-dropdown-link>
                    <x-sidebar-dropdown-link :href="route('v2.siswa')" :active="Request::routeIs('v2.siswa')">Siswa</x-sidebar-dropdown-link>
                    <x-sidebar-dropdown-link :href="route('v2.complain-absen-mengajar')" :active="Request::routeIs('v2.complain-absen-mengajar')">Complain Absen</x-sidebar-dropdown-link>
                    <x-sidebar-dropdown-link :href="route('v2.absen-alternatif')" :active="Request::routeIs('v2.absen-alternatif')">Absen Alternatif</x-sidebar-dropdown-link>
                </x-sidebar-dropdown>
             </li>

        </ul>
        {{-- <ul class="hidden md:block">
            <li x-data="{ absensi: {{ Request::is('v2/laporan/absen-siswa') || Request::is('v2/laporan/absen-siswa/*') ? 'true' : 'false' }} }">
                <x-sidebar-dropdown x-on:click="absensi = !absensi" :active="Request::is('v2/admin/absensi') || Request::is('v2/admin/absensi/*')" data="absensi" label='Absensi Siswa'>
                    @slot('svg')
                    <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9"/>
                    </svg>
                      
                    @endslot
                    <x-sidebar-dropdown-link :href="route('v2.laporan.absen-siswa')" :active="Request::routeIs('v2.laporan.absen-siswa')">Absen Siswa</x-sidebar-dropdown-link>
                </x-sidebar-dropdown>
             </li>
        </ul> --}}
        <ul class="hidden md:block">
            <li x-data="{ absensi: {{ Request::is('v2/admin/laporan') || Request::is('v2/admin/laporan/*') ? 'true' : 'false' }} }">
                <x-sidebar-dropdown x-on:click="absensi = !absensi" :active="Request::is('v2/admin/absensi') || Request::is('v2/admin/absensi/*')" data="absensi" label='Absensi Pegawai'>
                    @slot('svg')
                    <svg class="flex-shrink-0 w-5 h-5 transition duration-1000 group-hover:rotate-180" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9"/>
                    </svg>
                      
                    @endslot
                    <x-sidebar-dropdown-link :href="route('v2.staff-attandance-report')" :active="Request::routeIs('v2.staff-attandance-report')">Laporan Absen</x-sidebar-dropdown-link>
                    <livewire:layouts.office-trip-check>
                </x-sidebar-dropdown>
             </li>
        </ul>


        
    </ul>
    @if (Request::is('v2/admin/*'))
    <ul class="grid grid-cols-3 gap-2 text-xs font-medium md:space-y-2 md:grid-cols-1" x-data="{menu:'user'}">
        @if (Request::is('v2/admin/akun') ||Request::is('v2/admin/akun/*'))
        <button x-on:click="menu='user'">Pengguna</button>
        <button x-on:click="menu='complain'">complan</button>
        <div x-show="menu == 'user'">
            <x-sidebar-link :href="route('v2.akun')" :active="Request::is('v2/admin/akun/*')" label="User">
                <svg class="flex-shrink-0 w-5 h-5 transition duration-75"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 18">
                    <path
                        d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                </svg>
            </x-sidebar-link>
        </div>
        <div x-show="menu == 'complain'">
            <p>Complain</p>
        </div>
        @endif
    <ul>
    @endif
</aside>