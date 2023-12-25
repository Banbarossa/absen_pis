<x-guest-layout>
    <x-form-card>

        <div class="p-3">
            @if (session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
            <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
                @csrf

                <x-text-input label="Email" name="email" type="email" />

                <x-text-input label="Password" name="password" type="password"  required autocomplete="current-password" />

                <div class="form-group row">
                    <div class="col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember_me">
                            <label class="custom-control-label" for="remember_me">Remember me</label>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

                <div class="form-group m-t-10 mb-0 row">
                    @if (Route::has('password.request'))
                    <div class="col-sm-7 m-t-20">
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your password ?</small></a>
                    </div>
                    @endif
                    <div class="col-sm-5 m-t-20">
                        <a href="{{route('register')}}" class="text-muted"><i class="mdi mdi-account-circle"></i> <small>Create an account ?</small></a>
                    </div>
                </div>
            </form>
        </div>

    </x-form-card>

</x-guest-layout>