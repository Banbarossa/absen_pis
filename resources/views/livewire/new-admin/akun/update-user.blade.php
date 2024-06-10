<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <x-admin-template>
        <form action="" wire:submit.prevent='storeIdentitas'>
        <div class="mb-3">
            <x-input-label class="mb-2" for='name'>{{ __('Name') }}</x-input-label>
            <x-text-input-tailwind wire:model='name' id='name' type='text'></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('name')"></x-input-error>
        </div>
        <div class="mb-3">
            <x-input-label class="mb-2" for='email'>{{ __('Email') }}</x-input-label>
            <x-text-input-tailwind wire:model='email' id='email' type='email'></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('email')"></x-input-error>
        </div>

        <div class="mb-3">
            <x-input-label class="mb-2" for='password_absen'>{{ __('Password Absen') }}</x-input-label>
            <x-text-input-tailwind wire:model='password_absen' id='password_absen' type='text'></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('password_absen')"></x-input-error>
        </div>

        <div class="mt-4">
            <x-primary-button class="" type='submit'>{{ __('Submit') }}</x-primary-button>
        </div>

        
        </form>


    </x-admin-template>

    <x-admin-template>
        <livewire:new-admin.akun.update-password-user :user="$user">
        {{-- resources/views/livewire/new-admin/akun/update-password-user.blade.php --}}
    </x-admin-template>
</div>
