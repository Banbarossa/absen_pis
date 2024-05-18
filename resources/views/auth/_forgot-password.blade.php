<x-guest-layout>
    <x-form-card>
        
        <div class="p-3">
            <div class="mb-4 text-sm text-muted">
                <small>
                    {{ __('Tidak ingat kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda, dan kami akan mengirimkan tautan reset kata sandi melalui email yang memungkinkan Anda untuk memilih yang baru.') }}
                </small>
            </div>
        
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
        
                <!-- Email Address -->
                <div>
                  
                    <x-text-input type="email" name="email" label="email" :value="old('email')" required autofocus/>
                </div>
                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Submit</button>
                    </div>
                </div>
            </form>
    
        </div>
       

    </x-form-card>
   
</x-guest-layout>
