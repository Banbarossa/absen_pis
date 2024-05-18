<x-absen>
    <x-slot:title>
        Forgot Password
    </x-slot:title>

    <div class="mb-8">
        <h3 class="mt-8 text-xl font-extrabold text-red-800">Recovery Akun</h3>
        <p class="text-sm">
            Silahkan Masukkan email anda untuk recovery akun
        </p>

    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="relative mb-4">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </div>
            <input type="email" name="email" value="{{ old('email') ?? '' }}" required autofocus id="input-group-1" class="bg-gray-50 bg-opacity-60 border border-red-600  text-gray-900 rounded-xl focus:ring-red-500 focus:border-red-500 focus:ring-1 focus:ring-offset-2 block w-full  px-2.5  py-2 dark:bg-gray-700 text-center dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" placeholder="Email">
        </div>
        <button type="submit" class="inline-flex items-center justify-center w-full gap-2 px-5 py-2 mt-4 font-medium text-center text-white bg-red-700 rounded-full hover:bg-red-800 ring-1 ring-offset-2 ring-red-600 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            <span>Submit</span>
        </button>

    </form>
</x-absen>