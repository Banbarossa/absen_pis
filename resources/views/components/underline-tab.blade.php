
@props(['active'])

@php
    $classes =($active ?? false)
    ?'inline-block p-2 text-red-700 border-b-2 border-red-700 rounded-t-lg active dark:text-red-500 dark:border-red-500'
    :'inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300';
@endphp

<li class="me-2">
    <a href="javascript:void()" {{ $attributes->merge(['class'=>$classes]) }} >{{ $slot }}</a>
</li>