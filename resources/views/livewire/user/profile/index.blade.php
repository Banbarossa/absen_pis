<div class="grid w-full grid-cols-1 gap-6 md:grid-cols-2">
    <div class="p-4 bg-white rounded-xl">
        <h3 class="mb-4 text-lg font-semibold text-red-700">{{ __('Update Profile') }}</h3>
        <form action="" wire:submit.prevent='updateProfile'>
            <div class="mb-4">
                <x-input-label for="email" class="mb-1">{{ __('Email') }}</x-input-label>
                <x-text-input-tailwind wire:model='email' id='email' disabled></x-text-input-tailwind>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <div class="mb-4">
                <x-input-label for="name" class="mb-1">{{ __('Nama') }}</x-input-label>
                <x-text-input-tailwind wire:model='name' id='name'></x-text-input-tailwind>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div class="mb-4">
                <x-input-label for="password_absen" class="mb-1">{{ __('Password Absen') }}</x-input-label>
                <x-text-input-tailwind wire:model='password_absen' id='password_absen'></x-text-input-tailwind>
                <x-input-error :messages="$errors->get('password_absen')" class="mt-1" />
            </div>
            <div>
                <x-primary-button>Submit</x-primary-button>
            </div>
        </form>
    </div>
    <div>
        <livewire:user.profile.update-password>
    </div>
</div>
