<div class="topbar">
    
    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">
            @role('admin')
            <li class="list-inline-item dropdown notification-list hide-phone">
                <p class="text-white">{{\App\Traits\SemesterAktif::getSemesterAktif()->nama_semester .' '.\App\Traits\SemesterAktif::getSemesterAktif()->tahun}}</p>
                {{-- <a href="/calendar-event" class="nav-link dropdown-toggle arrow-none waves-effect">
                    semester
                </a> --}}
            </li>
            <li class="list-inline-item dropdown notification-list hide-phone">
                <a href="/calendar-event" class="nav-link dropdown-toggle arrow-none waves-effect">
                    <i class="mdi mdi-timetable noti-icon"></i>
                </a>
            </li>
            
            @endrole
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-forum noti-icon"></i>
                    <span class="badge badge-danger noti-icon-badge" id="jumlah_pesan"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                    <div class="dropdown-item noti-title">
                        <a href="/chatify" target="_blank" rel="noopener noreferrer"><span class="badge badge-danger float-right" id="jumlah_pesan"></span>Perpesanan</a>
                    </div>
                    {{-- Loping Pesan dengan javascrip --}}
                    <div id="looping_pesan"></div>

                </div>
            </li>

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                   <img src="{{asset('assets/images/avatar.png')}}" alt="user" class="rounded-circle">
                  
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <small>{{Auth::user()->name}}</small>
                    </div>
                    <a class="dropdown-item" href="/user-profile"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <div class="">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit"><i class="mdi mdi-logout m-r-5 text-muted"></i>Log Out</button>
                        </form>
                    </div>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-light waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>

        </ul>

        <div class="clearfix"></div>

    </nav>

</div>

