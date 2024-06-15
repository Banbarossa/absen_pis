@props(['active','href'=>'#'])

@php
    $classes = ($active ?? false)
    ?'flex items-center w-full p-1 text-gray-900 transition duration-75 rounded-lg ps-4 group hover:bg-red-300 dark:hover:bg-gray-700 bg-red-300'
    :'flex items-center w-full p-1 text-gray-900 transition duration-75 rounded-lg ps-4 group hover:bg-red-300 dark:hover:bg-gray-700';
@endphp

<li>
   <a href="{{ $href }}" {{ $attributes->merge(['class'=>$classes]) }} >{{ $slot }}</a>
</li>