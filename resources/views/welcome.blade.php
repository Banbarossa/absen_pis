<x-absen>
    <x-slot:title>
        Login
    </x-slot:title>

    <x-jam-absen></x-jam-absen>

    <x-notif-absen></x-notif-absen>

    <figure>
        <img src="{{ asset('assets/images/worker.png') }}" class="w-1/3 mx-auto" alt="worker">
    </figure>
    <h3 class="mt-8 mb-4 text-xl font-extrabold text-red-800">Login</h3>
    
    @if ($errors->any())
    <x-alert-error :errors="$errors"></x-alert-error>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="relative mb-4">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg class="w-6 h-6 text-gray-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </div>
            <input type="email" name="email" value="{{ old('email') ?? '' }}" id="input-group-1" class="bg-gray-50 bg-opacity-60 border border-red-600  text-gray-900 rounded-xl focus:ring-red-500 focus:border-red-500 focus:ring-1 focus:ring-offset-2 block w-full  px-2.5  py-2 dark:bg-gray-700 text-center dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" placeholder="Email">
        </div>
        <div x-data="{show:false}">
            <div class="relative" >
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-6 h-6 text-gray-400"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14v3m4-6V7a3 3 0 1 1 6 0v4M5 11h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
                    </svg>
                </div>
                <input x-bind:type="show ? 'text':'password'" name="password" id="input-group-1" class="bg-gray-50 bg-opacity-60 border border-red-600  text-gray-900 rounded-xl focus:ring-red-500 focus:border-red-500 focus:ring-1 focus:ring-offset-2 block w-full  px-2.5  py-2 dark:bg-gray-700 text-center dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" placeholder="Password">
            </div>
            <button type="button" x-on:click="show = !show" >
                <span class="text-xs" x-text="show ? 'Sembunyikan Password' : 'Tampilkan Password'"></span>
            </button>
        </div>

        <button type="submit" class="inline-flex items-center justify-center w-full gap-2 px-5 py-2 mt-4 font-medium text-center text-white bg-red-700 rounded-full hover:bg-red-800 ring-1 ring-offset-2 ring-red-600 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            <span>Login</span>
        </button>

    </form>

    <div class="py-6 text-center">
        @if (Route::has('password.request'))
        <div class="col-sm-7 m-t-20">
            <a href="{{ route('password.request') }}" class="text-xs text-gray-700"> Lupa Password ?</a>
        </div>
        @endif
        <div class="col-sm-5 m-t-20">
            <a href="javascript:void(0)" class="text-muted" data-toggle="modal" data-target="#exampleModalLong-1"><i class="mdi mdi-account-circle"></i> <small>Buat Akun ?</small></a>
        </div>
    </div>
    

    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let successMessageElement = document.getElementById('success-message');
            let errorMessageElement = document.getElementById('error-message');

            if (successMessageElement) {
                let message = successMessageElement.getAttribute('data-message');
                let notifSuccess = document.getElementById('notif-success');
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'close',
                })
                notifSuccess.play();
            }

            if (errorMessageElement) {
                let message = errorMessageElement.getAttribute('data-message');
                let notifError = document.getElementById('notif-error');
                Swal.fire({
                    title: 'Error!',
                    text: message,
                    icon: 'error',
                    confirmButtonText: 'close',
                })

                notifError.play();
            }
        });
    </script>
    @endpush
</x-absen>