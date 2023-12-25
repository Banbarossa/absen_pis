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
        <style>
            .nav-bottom{
                position: absolute;
                bottom: 0;
                left: 0px;
                right: 0px;
                margin-top: 50px

            }
            .nav-wrapper{
                position: sticky;
                bottom: 0;
                top: 0px;
                left: 0px;
                right: 0px;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                place-items: center;
                gap: 4px;
                z-index: 999;
            }
            .nav-bottom a{

                color: white

            }

        </style>

    </head>


    <body class="fixed-left">
        {{-- @include('layouts.guest-navbar') --}}
        <div class=" min-vh-100 d-flex">
            <div class="d-none d-lg-block col-lg-8 accountbg" id="ripple"></div>
            <div class="col-12 col-lg-4" style="padding-top:1rem; padding-bottom:4rem">
                {{$slot}}
                <div class="nav-bottom p-1 bg-primary">
                    <div class="nav-wrapper">
                        <a class="nav-link {{Request::is('/') ? 'active' :''}}" href="/">Home <span class="sr-only">(current)</span></a>
                        <a class="nav-link {{Request::routeIs('login') ? 'active' :''}}" href="{{route('login')}}">Login</a>
                        <a class="nav-link {{Request::routeIs('register') ? 'active' :''}}" href="{{route('register')}}">Register</a>

                    </div>

                </div>
                
            </div>
        </div>

        @include('layouts.js')
        @stack('script')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src='https://cdn.jsdelivr.net/npm/jquery.ripples@0.6.3/dist/jquery.ripples.min.js'></script>
        <script>
             $('#ripple').ripples({
                resolution: 400,
                dropRadius: 20,
                perturbance: 0.02,
             })
        </script>
      <x-livewire-alert::scripts />
    </body>

</html>