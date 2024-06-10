<div>
    <form action="" wire:submit.prevent='store'>
        <div class="mb-3">
            <x-input-label class="mb-2" for="user_id">{{ __('Nama Musyrif') }}</x-input-label>
            <select id="countries" wire:model.live='user_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 ">
                <option selected>Pilih Musyrif</option>
                @foreach ($user as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('user_id')"></x-input-error>
        </div>
        <div>
            <x-input-label class="mb-2" for="nama_halaqah">{{ __('Nama Halaqah') }}</x-input-label>
            <x-text-input-tailwind type="text" class="w-full" wire:model='nama_halaqah'></x-text-input-tailwind>
            <x-input-error :messages="$errors->get('nama_halaqah')"></x-input-error>

        </div>
        <div class="mt-4">
            <x-primary-button type='submit'>Submit</x-primary-button>
        </div>
    </form>
</div>