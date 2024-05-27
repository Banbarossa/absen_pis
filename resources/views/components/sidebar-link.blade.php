
@props(['active','href'=>'#','label'=>'No Label'])

@php
    $classes = ($active ?? false)
    ?'flex flex-col items-center justify-center p-2 rounded-lg dark:text-white hover:bg-red-100 dark:hover:bg-red-700 group bg-red-100 text-red-900'
    :'flex flex-col items-center justify-center p-2 text-gray-700 rounded-lg dark:text-white hover:bg-red-100 dark:hover:bg-red-700 group'
@endphp
<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class'=>$classes]) }}>
        {{ $slot }}
        <span class="flex-1 whitespace-nowrap">{{ $label }}</span>
    </a>
</li>