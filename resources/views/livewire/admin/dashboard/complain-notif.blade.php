<div>
    @role('admin|hrd')
    @if ($jlh_luardinas > 0)
    <li class="p-2 py-2 mb-4 bg-red-200 rounded-lg sm:pb-4 animate-pulse">
        <a href="{{ route('v2.office-trip-report') }}">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="{{ asset('assets/images/worker.png') }}" alt="mengajar">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $jlh_luardinas }} Absen luar dinas Belum diproses
                    </p>
                </div>
            </div>
        </a>
    </li>
    @endif
    @endrole
    @role('admin|musyrif halaqah')
    @if ($jlh_halaqah > 0)
    <li class="p-2 py-2 mb-4 bg-red-200 rounded-lg sm:pb-4 animate-pulse">
        <a href="{{ route('v2.complain-absen-halaqah') }}">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="{{ asset('assets/images/halaqah.png') }}" alt="Halaqah">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $jlh_halaqah }} Complain Absen Halaqah Belum diproses
                    </p>
                </div>
            </div>
        </a>
    </li>
    @endif
    @endrole
    @role('admin')
    @if ($jlh_mengajar > 0)
    <li class="p-2 py-2 mb-4 bg-red-200 rounded-lg sm:pb-4 animate-pulse">
        <a href="{{ route('v2.complain-absen-mengajar') }}">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="{{ asset('assets/images/mengajar.png') }}" alt="mengajar">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $jlh_mengajar }} Complain Mengajar Belum diproses
                    </p>
                </div>
                
            </div>
        </a>
    </li>
    @endif
    @endrole
    @role('admin')
    @if ($jlh_absen_alternatif > 0)
    <li class="p-2 py-2 mb-4 bg-red-200 rounded-lg sm:pb-4 animate-pulse">
        <a href="{{ route('v2.absen-alternatif') }}">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="{{ asset('assets/images/mengajar.png') }}" alt="mengajar">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $jlh_absen_alternatif }} Absen Alternatif Belum diproses
                    </p>
                </div>
                
            </div>
        </a>
    </li>
    @endif
    @endrole
   

</div>