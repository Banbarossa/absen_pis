<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{config('app.name')}}</title>
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        {{-- <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}">

    </head>


    <body>

        <div class="wrapper min-vh-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-light d-none d-lg-flex">
                <div class="container d-flex justify-content-between">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
        
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">
                                    Dropdown
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </li>
        
                        </ul>
        
                    </div>
                </div>
    
            </nav>
            {{$slot}}
    
    
            <section class="footer d-lg-none bg-warning">
                <div class="container">
                    <ul class="horizontal-list">
                        <li><a href="">safa</a></li>
                        <li><a href="">safa</a></li>
                        <li><a href="">safa</a></li>
                        <li><a href="">safa</a></li>
                    </ul>
                </div>
            </section>
    
        </div>



        <script>
         window.addEventListener('close-modal',event=>{
             $('#crudModal').modal('hide');
         })

        </script>

        @stack('script')

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
        <x-livewire-alert::scripts />

        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    </body>
</html>