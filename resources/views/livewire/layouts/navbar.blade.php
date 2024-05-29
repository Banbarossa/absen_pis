<nav class="top-0 left-0 right-0 z-50 bg-white border-gray-200 md:fixed dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('assets/images/logo.png')}}" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Pesantren Imam Syafi'i</span>
        </a>
        <div class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse">
            <button type="button"
                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-red-300 dark:ring-gray-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full ring-2 ring-offset-2 ring-gray-400" src="{{ asset('assets/images/avatar.png') }}" alt="user photo">
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ $user->name }}</span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ $user->email }}</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ route('v2.profile') }}" 
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" wire:click='logout'
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            Sign Out
                        </a>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                
                <x-navbar-link :href="route('v2.dashboard')" :active="Request::routeIs('v2.dashboard') || Request::is('v2/home/*')">Home</x-navbar-link>

                {{-- <x-navbar-link :href="route('v2.akun')" :active="Request::is('v2/admin/akun') || Request::is('v2/admin/akun/*')">Pengguna</x-navbar-link>
                
                <x-navbar-link :href="route('v2.akun')" :active="Request::is('v2/admin/akun') || Request::is('v2/admin/akun/*')">Pengguna</x-navbar-link> --}}
                
            </ul>
        </div>
    </div>
</nav>