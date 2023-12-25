<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Update Profile</h4>
        </x-header>

        <div class="row">
            {{-- musyria Area --}}
            <div class="col-lg-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h4 class="mt-0 header-title">Update Profile</h4>
                        </div>
                        <form action="" wire:submit='updateProfile'>
                            <x-text-input-livewire type="text" name="name" label="Nama"></x-text-input-livewire>
                            <x-text-input-livewire type="email" name="email" label="email" :disabled='true'></x-text-input-livewire>
                            <x-text-input-livewire type="text" name="password_absen" label="Password Absen"></x-text-input-livewire>

                            <button class="btn btn-primary mt-3" type="submit">Update Profile</button>
                        </form>

        
                    </div>
                </div>
            </div>


            {{-- non musyrif Area --}}
            <div class="col-lg-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Update Password</h4>
                        </div>
                        <form action="" wire:submit='updatePassword'>
                            <x-text-input-livewire type="password" name="old_password" label="Password Lama"></x-text-input-livewire>
                            <x-text-input-livewire type="password" name="new_password" label="Password Baru"></x-text-input-livewire>
                            <x-text-input-livewire type="password" name="password_confirmation" label="Password Confirmation"></x-text-input-livewire>

                            <button class="btn btn-primary mt-3" type="submit">Update Password</button>
                        </form>


       
        
                    </div>
                </div>
            </div>
        </div>
        







    </x-content-area>
</div>
