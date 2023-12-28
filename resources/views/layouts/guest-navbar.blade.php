<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm" style="height:4rem">
    <div class="container">
        <a class="navbar-brand" href="https://pis.sch.id" target="blank">Pesantren <span class="text-warning">{{config('app.name')}}</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-sm-none" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                {{-- <a class="nav-link mr-4 {{Request::is('/') ? 'active' :''}}" href="/">Home <span class="sr-only">(current)</span></a>
                <a class="nav-link mr-4 {{Request::routeIs('login') ? 'active' :''}}" href="{{route('login')}}">Login</a>
                <a class="nav-link mr-4 {{Request::routeIs('register') ? 'active' :''}}" href="{{route('register')}}">Register</a> --}}
            </div>
        </div>
    </div>
</nav>