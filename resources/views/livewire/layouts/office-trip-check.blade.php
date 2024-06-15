<x-sidebar-dropdown-link 
    :href="route('v2.office-trip-report')" 
    :active="Request::routeIs('v2.office-trip-report')"
    class="relative"
    >
    Absen Tugas Luar
    @if ($jumlah > 0)
    <div class="absolute flex items-center justify-center w-6 h-6 text-sm text-red-700 -translate-y-1/2 bg-red-200 rounded-full right-3 top-1/2">{{ $jumlah }}</div>
    @endif
</x-sidebar-dropdown-link>
