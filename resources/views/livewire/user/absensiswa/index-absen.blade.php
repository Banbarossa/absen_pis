<x-admin-template>
    <div class="mb-4 text-lg ">
        Absensi Siswa Kelas <span class="font-extrabold text-red-700">{{ strtoupper($rombelName) }}</span>
    </div>
    <div>
        <form action="" wire:submit.prevent='store'>
            <ul class="py-2 divide-y-2">
                @forelse ($siswarombel as $item)
                <li class="py-2">
                    <p class="mb-2 text-xs font-bold md:text-sm ">{{ $item->name }}</p>
                    <div class="flex gap-4 text-xs text-gray-400">
                        <div>
                            <input class="me-2" type="radio" name="{{ $item->id }}" wire:model="attendance.{{ $item->id }}" value="h" id="hadir" checked>
                            <label for="hadir">{{ __('Hadir') }}</label>
                        </div>
                        <div>
                            <input class="me-2" type="radio" name="{{ $item->id }}" wire:model="attendance.{{ $item->id }}" value="s" id="sakit">
                            <label for="sakit">{{ __('Sakit') }}</label>
                        </div>
                        <div>
                            <input class="me-2" type="radio" name="{{ $item->id }}" wire:model="attendance.{{ $item->id }}" value="i" id="izin">
                            <label for="izin">{{ __('Izin') }}</label>
                        </div>
                        <div>
                            <input class="me-2" type="radio" name="{{ $item->id }}" wire:model="attendance.{{ $item->id }}" value="a" id="alpa">
                            <label for="alpa">{{ __('Alpa') }}</label>
                        </div>
                    </div>
                </li>
                @empty
                    <li>{{ __('Tidak ada data siswa yang ditemukan') }}</li>
                @endforelse
            </ul>
            @if($siswarombel->isNotEmpty())
            <button type="submit" class="px-4 py-2 text-sm text-white bg-red-700 rounded-lg">Submit</button>
            @endif
        </form>
    </div>
</x-admin-template>
