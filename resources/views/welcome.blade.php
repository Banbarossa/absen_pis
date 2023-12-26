<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{config('app.name')}}</title>
    <meta content="Guest" name="Absensi Digital Pesantren Imam Syafii" />
 

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    @include('layouts.css')
    <link rel="stylesheet" href="{{asset('assets/css/home.css')}}">


</head>


<body class="fixed-left">
    @include('layouts.guest-navbar')
    <div class="container mt-4">
        <div class="row mb-4" id="logo">
            <div class="col-12 d-flex align-items-center">
                <img src="{{asset('assets/images/favicon.ico')}}" alt="logo">
                <span class="ml-3">
                    <h5 class="text-primary mb-0">ABSENSI DIGITAL</h5>
                    <p class="mt-0">Pesantren Imam Syafi'i</p>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="mdi mdi-lock mr-3"></i>Login
                    </div>
                    <div class="card-body">
                        <div >
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
                                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> <small>Lupa Password ?</small></a>
                                    </div>
                                    @endif
                                    <div class="col-sm-5 m-t-20">
                                        <a href="javascript:void(0)" class="text-muted" data-toggle="modal" data-target="#exampleModalLong-1"><i class="mdi mdi-account-circle"></i> <small>Buat Akun ?</small></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="mdi mdi-information mr-3"></i>Informasi
                    </div>
                    <div class="card-body">
                        @if ($informasi)
                        <p class="text-muted mb-0"><strong>{{$informasi->title}}</strong></p>
                        <small class="mt-0">{{\Carbon\Carbon::parse($informasi->created_at)->diffForHumans()}}</small>
                        <p class="mt-3">{!! $informasi->content !!}</p>
                        @else
                        <p class="mt-3">{{Belum Ada Informasi}}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="mdi mdi-help mr-3"></i>Pengetahuan
                    </div>
                    <div class="card-body">
                        @if ($pengetahuan)
                        <p class="text-muted mb-0"><strong>{{$pengetahuan->title}}</strong></p>
                        <small class="mt-0">{{\Carbon\Carbon::parse($pengetahuan->created_at)->diffForHumans()}}</small>
                        <p class="mt-3">{!! $pengetahuan->content !!}</p>
                        @else
                        <p class="mt-3">{{Belum Ada Data}}</p>
                        @endif
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle-1">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    @include('layouts.js')
 
      
    <x-livewire-alert::scripts />

</body>

</html>
