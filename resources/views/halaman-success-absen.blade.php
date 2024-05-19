<x-absen>
    <x-slot:title>
        Absen Berhasil
    </x-slot:title>

    <x-jam-absen></x-jam-absen>

    <x-notif-absen></x-notif-absen>

    <figure>
        <img src="{{ asset('assets/images/worker.png') }}" class="w-1/3 mx-auto" alt="worker">
    </figure>
    <h3 class="mt-8 text-2xl font-extrabold text-red-800">Absen Berhasil</h3>
    <p class="text-sm font-thin">
        Absen Berhasil, Silahkan lanjutkan Aktifitas Anda!
    </p>

    <a href="{{ route('welcome') }}" class="mt-8 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
        <svg class="w-5 h-5 mr-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
          </svg>
          
        Kembali Ke Halaman Utama
    </a>

    @push('script')
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
                    timer:2500,
                    toast:true,
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
                    timer:2500,
                    toast:true,
                    confirmButtonText: 'close',
                })

                notifError.play();
            }
        });
        
    </script>
        
    @endpush
</x-absen>