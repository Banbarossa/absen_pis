<x-guest-layout>
    <x-form-card>


        <div class="p-3">
           
            <form class="form-horizontal m-t-20" method="POST" action="{{ route('password.store') }}">
                @csrf

                 <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}"/>

                <x-text-input label="Email" name="email" type="email" required autofocus autocomplete="username" />

                <x-text-input label="Password" name="password" type="password"  required autocomplete="current-password" />

                <x-text-input label="Confirm Password" name="password_confirmation" type="password"  required autocomplete="current-password" />


                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Reset Password</button>
                    </div>
                </div>

              
            </form>
        </div>

    </x-form-card>

</x-guest-layout>