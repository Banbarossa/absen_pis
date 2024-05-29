
@props(['active','href'=>'#','label'=>'No Label'])

@php
    $classes = ($active ?? false)
    ?'flex flex-col md:flex-row items-center justify-center md:justify-start px-6 py-2 rounded-lg dark:text-white hover:bg-red-700 dark:hover:bg-red-800 group bg-red-700 text-white hover:text-white min-h-14 md:min-h-0'
    :'flex flex-col md:flex-row items-center justify-center md:justify-start px-6 py-2 text-gray-700 rounded-lg dark:text-white hover:bg-red-600 dark:hover:bg-red-700 group hover:text-white min-h-14 md:min-h-0'
@endphp


<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class'=>$classes]) }}>
        {{ $slot }}
        <span class="flex-1 text-xs md:ms-3 whitespace-nowrap md:text-sm">{{ $label }}</span>
    </a>
</li>