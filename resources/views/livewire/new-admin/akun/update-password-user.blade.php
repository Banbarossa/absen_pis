<div x-data='{showPassword:false}'>
    <form action="" wire:submit.prevent='store'>
        <div class="mb-4">
            <x-input-label for='password' class="mb-2">{{ __('Password Baru') }}</x-input-label>
            <x-text-input-tailwind wire:model='password' x-bind:type="showPassword == true ? 'text':'password'"></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('password')"></x-input-error>
        </div>
        <div class="mb-4">
            <x-input-label for='password_confirmation' class="mb-2">{{ __('Konfirmasi Password') }}</x-input-label>
            <x-text-input-tailwind wire:model='password_confirmation' x-bind:type="showPassword == true ? 'text':'password'"></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('password_confirmation')"></x-input-error>
        </div>

        <div>
            <button type="button" class="flex items-center gap-3 text-xs" x-on:click="showPassword = !showPassword" x-bind:class="{ 'justify-between': showPassword, 'justify-start': !showPassword }">
                <span>
                    <svg stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path x-bind:class="{ 'hidden': showPassword }" stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                        <path x-bind:class="{ 'hidden': showPassword }" stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path x-bind:class="{ 'hidden': !showPassword }" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </span>
                <span x-text="showPassword ? 'Hide Password' : 'Show Password'" class="ms-2"></span>
            </button>
        </div>


        <div class="mt-4">
            <x-primary-button type='submit'>{{ __('Submit') }}</x-primary-button>
        </div>
    </form>

</div>
