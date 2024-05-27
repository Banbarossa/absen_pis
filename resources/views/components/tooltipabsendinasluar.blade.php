@props(['data'])


@php
    if (is_null($data->approval)) {
        $color ='text-orange-400';
        $tooltip = 'Belum Verifikasi';
    }elseif (!$data->approval) {
        $color ='text-red-700';
        $tooltip = 'Ditolak';
    } else {
        $color ='text-green-500';
        $tooltip = 'Diterima';
    }
@endphp
<div x-data="{ket:false}" x-on:click.outside="ket = false">
    <button class="text-sm text-blue-700 hover:underline hover:underline-offset-1" x-on:click="ket = !ket">Tugas Dinas Luar</button>
    <div class="text-xs text-gray-600" x-show="ket">
        {{ $data->keterangan }}
    </div>
    <div>
        <button data-tooltip-target="tooltip-left" data-tooltip-placement="left" type="button" class="{{ $color }} absolute top-2 right-2">
            @if (is_null($data->approval))
                <span>
                    <svg class="w-6 h-6" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </span>
            @elseif($data->approval)
                <span>
                    <svg class="w-6 h-6" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </span>
            @else
                <span>
                    <svg class="w-6 h-6" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </span>
            @endif
        </button>
        <div id="tooltip-left" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            {{ $tooltip }}
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</div>