
@props(['href'=>'#','ariaCurrent'=>'#','active'])


@php
    $classes= ($active ?? false) 
    ? 'block px-3 py-2 text-white bg-red-700 rounded md:bg-transparent md:text-red-700 md:p-0 md:dark:text-red-500'
    :'block px-3 py-2 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 dark:text-white md:dark:hover:text-red-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700'
@endphp


<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class'=>$classes]) }}
        aria-current="{{ $ariaCurrent }}">{{ $slot }}</a>
</li>