<x-absen>
    <x-slot:title>
        {{ isset($title) ? $title :' Galat' }}
    </x-slot:title>

    <x-jam-absen></x-jam-absen>
    <figure class="mt-6 text-center">
        <img src="{{ asset('assets/images/404.png') }}" class="object-cover w-1/2 mx-auto" alt="404">
    </figure>

        <div class="mt-10">
            @if (isset($judul))
                <h4 class="text-2xl font-bold text-red-800">{{ $judul }}</h4>
            @endif

            @if (isset($content))
                <p class="mt-2 text-gray-700">{{ $content }}</p>
            @endif
        </div>
</x-absen>