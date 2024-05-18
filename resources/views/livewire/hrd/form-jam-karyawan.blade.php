<div class="row">
    <div class="col-12">
        <x-text-input-livewire
            name="nama_jam_kerja"
            wire:model='nama_jam_kerja'
            label='Nama jam Kerja'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="jam_masuk_1"
            wire:model='jam_masuk_1'
            label='Jam Masuk 1'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="mulai_absen_masuk_1"
            wire:model='mulai_absen_masuk_1'
            label='Mulai Akses Absen Masuk 1'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="akhir_absen_masuk_1"
            wire:model='akhir_absen_masuk_1'
            label='Akhir Akses Absen Masuk 1'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="jam_masuk_2"
            wire:model='jam_masuk_2'
            label='Jam Masuk 2'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="mulai_absen_masuk_2"
            wire:model='mulai_absen_masuk_2'
            label='Mulai Akses Absen Masuk 2'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="akhir_absen_masuk_2"
            wire:model='akhir_absen_masuk_2'
            label='Akhir Akses Absen Masuk 2'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="jam_pulang"
            wire:model='jam_pulang'
            label='Jam Pulang'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="mulai_absen_pulang"
            wire:model='mulai_absen_pulang'
            label='Mulai Akses Absen Pulang'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-4">
        <x-text-input-livewire
            type="time"
            name="akhir_absen_pulang"
            wire:model='akhir_absen_pulang'
            label='Akhir Akses Absen Pulang'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12 col-lg-6">
        <x-text-input-livewire
            type="number"
            name="toleransi"
            wire:model='toleransi'
            label='Toleransi (dalam menit)'
            >
        </x-text-input-livewire>
    </div>
    <div class="col-12">
        <div class="my-2 checkbox">
            <div class="custom-control custom-checkbox" wire:click='updateischeckouttomorrow'>
                <input type="checkbox"  wire:model='ischeckouttomorrow' {{ $ischeckouttomorrow ? 'checked':''}} value="1" class="custom-control-input" id="customCheck3" data-parsley-multiple="groups" data-parsley-mincheck="2">
                <label class="custom-control-label" for="customCheck3">Apakah Absen Pulang Hari Berikutnya?</label>
            </div>
            @error('ischeckouttomorrow')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    
</div>