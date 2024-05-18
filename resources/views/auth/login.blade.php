<x-guest-layout>
    <x-form-card>

        <div class="p-3">
            @if (session('success'))
                <div id="success-message" data-message="{{ session('success') }}"></div>
            @endif

            @if (session('error'))
                <div id="error-message" data-message="{{ session('error') }}"></div>
            @endif

            <audio id="notif-error">
                <source src="{{ asset('assets/voice/gagal.mp3') }}" type="audio/mpeg">
            </audio>
            
            <audio id="notif-success">
                <source src="{{ asset('assets/voice/berhasil.mp3') }}" type="audio/mpeg">
            </audio>


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

                <div class="text-center form-group row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

                <div class="mb-0 form-group m-t-10 row">
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

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                let successMessageElement = document.getElementById('success-message');
                let errorMessageElement = document.getElementById('error-message');

                if (successMessageElement) {
                    let message = successMessageElement.getAttribute('data-message');
                    let notifSuccess = document.getElementById('notif-success');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: message,
                        icon: 'success',
                        confirmButtonText: 'close',
                    })
                    notifSuccess.play();
                }

                if (errorMessageElement) {
                    let message = errorMessageElement.getAttribute('data-message');
                    let notifError = document.getElementById('notif-error');
                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'close',
                    })

                    notifError.play();
                }
            });
        </script>
    @endpush

</x-guest-layout>