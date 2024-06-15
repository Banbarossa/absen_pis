@props(['active','label'=>'No Label' ,'data'])

@php
    $classes = ($active ?? false)
    ?'flex items-center w-full px-6 py-2 rounded-lg dark:text-white hover:bg-red-700 dark:hover:bg-red-800 group bg-red-700 text-white hover:text-white min-h-14 md:min-h-0 text-sm'
    :'flex items-center w-full px-6 py-2 text-gray-700 rounded-lg dark:text-white hover:bg-red-600 dark:hover:bg-red-700 group hover:text-white min-h-14 md:min-h-0 text-sm'
@endphp


<button type="button" {{ $attributes->merge(['class'=>$classes]) }} >
    {{ $svg }}
    <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">{{ $label }}</span>
    <span class="transition duration-500 {{ $active ? 'rotate-90':'' }}">
        <svg class="w-3 h-3"  stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
        </svg>
    </span>
</button>
<ul class="py-2 space-y-1 text-sm ms-12" x-show="{{ $data }}">
    {{ $slot }}
</ul>