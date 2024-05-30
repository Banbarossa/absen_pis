<div>
    <a href="{{ route('v2.akun') }}" class="relative flex items-center justify-between gap-4 p-4 bg-white border rounded-lg shadow-md min-h-28">
        <div class="w-16 overflow-hidden transition duration-500 border rounded-lg shadow-md h-w-16 hover:scale-105 hover:rotate-6">
            <img src="{{ asset('assets/images/worker.png') }}" class="object-cover aspect-square "  alt="worker" class="rounded-lg ">
        </div>
        <div class="space-y-0">
            <small class="text-xs text-gray-400">Jumlah Pegawai</small>
            <h1 class="text-2xl font-medium text-red-700">{{ $pegawai }} </h1>
            <p class="text-xs text-gray-400">Non Pegawai <span>{{ $nonPegawai }} Orang</span></p>
        </div>
        <div class="relative flex items-center self-end justify-center w-8 h-8 text-[10px] font-bold text-gray-800 bg-gray-400 border border-white border-dashed rounded-lg ring-2 ring-gray-300">
            {{ $aktif }}
            <span class="absolute bottom-0 right-0 animate-pulse">
                <svg class="flex-shrink-0 w-3 h-3 text-white transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 18">
                <path
                    d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                </svg>
            </span>
        </div>
    </a>
</div>
