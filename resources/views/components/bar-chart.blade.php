@props(['persen'=>0, 'color'=>'blue','label'=>'No Label'])

@php
    $textColor = "text-custom-{$color}";
    $bgColor = "bg-custom-{$color}";
@endphp

<div class="mb-2">

    <div class="flex justify-between w-full gap-4">
        <div class="w-20 text-[8px]">{{ $label }}</div>
        <div class="w-10">
            {{ $slot }}
        </div>
        <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full dark:bg-gray-700">
            <div class="{{ $bgColor }} text-[8px] font-medium text-blue-100  p-0.5  leading-none rounded-full text-nowrap" style="width: {{ $persen }}%"> 
                <p class="px-2 text-blue-200">{{ $persen }}%</p>
            </div>
        </div>
    </div>

</div>