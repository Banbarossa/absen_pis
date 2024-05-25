<div class="p-4 bg-white rounded-xl">
    <h3 class="mb-4 text-lg font-semibold text-red-700">{{ __('Update Profile') }}</h3>
    <form action="" wire:submit.prevent='store'>
        <div class="mb-4">
            <x-input-label for="old_password" class="mb-1">{{ __('Password Lama') }}</x-input-label>
            <x-text-input-tailwind wire:model='old_password' id='old_password' ></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('old_password')" class="mt-1" />
        </div>
        <div class="mb-4">
            <x-input-label for="new_password" class="mb-1">{{ __('Password Baru') }}</x-input-label>
            <x-text-input-tailwind wire:model='new_password' id='new_password'></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('new_password')" class="mt-1" />
        </div>
        <div class="mb-4">
            <x-input-label for="password_confirmation" class="mb-1">{{ __('Konfirmasi Password') }}</x-input-label>
            <x-text-input-tailwind wire:model='password_confirmation' id='password_confirmation'></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>
        <div>
            <x-primary-button>Submit</x-primary-button>
        </div>
    </form>
</div>
