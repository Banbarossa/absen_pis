<div>
    <x-content-area>
        <x-header>
            <h4 class="page-title">{{ __('Jam Karyawan') }}</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <form action="" wire:submit.prevent='store'>
                    @include('livewire.hrd.form-jam-karyawan')

                    <button type="submit" class="mt-4 btn btn-primary">Tambah Data</button>
                </form>
            </div>
        </div>
    </x-content-area>
</div>
