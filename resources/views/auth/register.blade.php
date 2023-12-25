<x-guest-layout>
    <x-form-card>

        <div class="p-3">
            <form class="form-horizontal m-t-20" method="POST" action="{{ route('register') }}">
                @csrf

                <x-text-input label="Name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" />

                <x-text-input label="Email" name="email" type="email" :value="old('email')" />

                <x-text-input label="Password" name="password" type="password" />

                <x-text-input label="Konfirmasi Password" name="password_confirmation" type="password" />


                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Register Now</button>
                    </div>
                </div>

                <div class="form-group m-t-10 mb-0 row">
                    
                    <div class="col-sm-5 m-t-20">
                        <a href="{{ route('login')}}" class="text-muted"><i class="mdi mdi-account-circle"></i> <small>{{ __('Sudah Mendaftar?') }}</small></a>
                    </div>
                </div>
            </form>
        </div>

    </x-form-card>

</x-guest-layout>