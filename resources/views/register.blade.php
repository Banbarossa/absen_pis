<x-absen>
    <x-slot:title>
        Register
    </x-slot:title>

    <h3 class="mt-8 mb-4 text-xl font-extrabold text-red-800">Register</h3>
    
    @if ($errors->any())
    <x-alert-error :errors="$errors"></x-alert-error>
    @endif

    <form class="form-horizontal m-t-20" method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="mb-6">
            <x-input-label for='name'>{{ __('Nama') }}</x-input-label>
            <x-text-input-tailwind placeholder="Nama Anda" id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete></x-text-input-tailwind>
        </div> 
        <div class="mb-6">
            <x-input-label for='email'>{{ __('Nama') }}</x-input-label>
            <x-text-input-tailwind placeholder="Email" id="email" type="email" name="email" :value="old('email')" ></x-text-input-tailwind>
        </div> 
        <div class="mb-6">
            <x-input-label for="password">{{ __('Password') }}</x-input-label>
            <x-text-input-tailwind id="password" placeholder="•••••••••" type="password" name="password" ></x-text-input-tailwind>
        </div> 
        <div class="mb-6">
            <x-input-label for="password_confirmation">{{ __('Password Konfirmasi') }}</x-input-label>
            <x-text-input-tailwind id="password_confirmation" placeholder="•••••••••" type="password" name="password_confirmation" ></x-text-input-tailwind>
        </div> 



        <button type="submit" class="inline-flex items-center justify-center w-full gap-2 px-5 py-2 mt-4 font-medium text-center text-white bg-red-700 rounded-full hover:bg-red-800 ring-1 ring-offset-2 ring-red-600 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            <span>Register</span>
        </button>
            
    </form>
    
    <div class="my-4">
        <a href="{{ route('login')}}" class="text-muted"><small>{{ __('Sudah Mendaftar?') }}</small></a>
    </div>



</x-absen>