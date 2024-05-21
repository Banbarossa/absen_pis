<div>
    <x-jam-absen></x-jam-absen>
    <figure class="mt-6 text-center">
        <img src="{{ asset('assets/images/404.png') }}" class="object-cover w-1/2 mx-auto" alt="404">
    </figure>

    <div class="mt-10">

        {{ $slot }}
    </div>
</div>