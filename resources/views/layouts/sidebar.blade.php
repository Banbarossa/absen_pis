<div id="sidebar-menu">
    <ul>
        <li class="menu-title">Main Menu</li>
        <li>
            <a href="/dashboard" class="waves-effect">
                <i class="mdi mdi-home"></i>
                <span> Dashboard </span>
            </a>
        </li>
        

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-fingerprint"></i> <span>Kehadiran Saya</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                @role('musyrif halaqah')
                <li class="{{Request::routeIs('absen.user.halaqah') ? 'active' :''}}">
                    <a href="{{route('user.absen.halaqah')}}" class="{{Request::routeIs('user.absen.halaqah') ? 'active' :''}}">Halaqah</a>
                </li>
                @endrole
                @role('guru')
                <li class="{{Request::routeIs('user.absen.mengajar') ? 'active' :''}}">
                    <a href="{{route('user.absen.mengajar')}}" class="{{Request::routeIs('user.absen.mengajar') ? 'active' :''}}">Mengajar</a>
                </li>
                @endrole
            </ul>
        </li>

        @role('admin')


        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-star"></i> <span>Admin</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                @php
                    $badgeComplainmengajar =\App\Models\Complainmengajar::where('status',null)
                @endphp
                <li class="{{Request::routeIs('admin.complain.mengajar') ? 'active' :''}}">
                    <a href="{{route('admin.complain.mengajar')}}" class="{{Request::routeIs('admin.complain.mengajar') ? 'active' :''}}">Complain Absen
                        @if ($badgeComplainmengajar->count())
                        <span class="float-right badge badge-pill badge-primary">{{$badgeComplainmengajar->count()}}
                        </span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        {{-- <li>
            <a href="/admin/complain-mengajar" class="waves-effect">
                <i class="mdi mdi-comment"></i>
                <span>
                    Complain
                    @php
                        $badgeComplainmengajar =\App\Models\Complainmengajar::where('status',null)
                    @endphp
                    @if ($badgeComplainmengajar->count())
                    <span class="float-right badge badge-pill badge-primary">{{$badgeComplainmengajar->count()}}
                    </span>
                    @endif
                </span>
            </a>
        </li> --}}
        @endrole
        


        
        
        @role('pengajaran|admin')
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-timetable"></i> <span> Pengajaran </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                <li class="{{Request::routeIs('pengajaran.guru') ? 'active' :''}}">
                    <a href="{{route('pengajaran.guru')}}" class="{{Request::routeIs('pengajaran.guru') ? 'active' :''}}">Guru</a>
                </li>
                <li class="{{Request::routeIs('pengajaran.mapel') ? 'active' :''}}">
                    <a class="{{Request::routeIs('pengajaran.mapel') ? 'active' :''}}" href="{{route('pengajaran.mapel')}}">Mata Pelajaran</a>
                </li>
                <li class="{{Request::routeIs('pengajaran.schedule') ? 'active' :''}}">
                    <a class="{{Request::routeIs('pengajaran.schedule') ? 'active' :''}}" href="{{route('pengajaran.schedule')}}">Pengaturan Jam</a>
                </li>
                <li class="{{Request::routeIs('pengajaran.rombel') ? 'active' :''}}">
                    <a class="{{Request::routeIs('pengajaran.rombel') ? 'active' :''}}" href="{{route('pengajaran.rombel')}}">Penjadwalan</a>
                </li>
            </ul>
        </li>
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-monitor"></i> <span> Laman Depan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                <li class="{{Request::routeIs('pengajaran.informasi') ? 'active' :''}}">
                    <a href="{{route('pengajaran.informasi')}}" class="{{Request::routeIs('pengajaran.informasi') ? 'active' :''}}">Informasi</a>
                </li>
                <li class="{{Request::routeIs('pengajaran.pengetahuan') ? 'active' :''}}">
                    <a href="{{route('pengajaran.pengetahuan')}}" class="{{Request::routeIs('pengajaran.pengetahuan') ? 'active' :''}}">Pengetahuan</a>
                </li>
            </ul>
        </li>

        @endrole
        {{-- halaqah --}}
        @role('hrd|admin')
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-poll"></i> <span> Laporan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                <li class="{{Request::routeIs('laporan.detail.personal') ? 'active' :''}}">
                    <a href="{{route('laporan.detail.personal')}}" class="{{Request::routeIs('laporan.detail.personal') ? 'active' :''}}">Detail Personal</a>
                </li>
                <li class="{{Request::routeIs('laporan.semua') ? 'active' :''}}">
                    <a href="{{route('laporan.semua')}}" class="{{Request::routeIs('laporan.semua') ? 'active' :''}}">Semua Jenjang</a>
                </li>
                @php
                    $sekolah= \App\Traits\ListSekolah::getData();
                @endphp
                @foreach ($sekolah as $item)
                <li class="{{Request::is('/laporan/sekolah/'.$item->id) ? 'active' :''}}">
                    <a href="{{route('laporan.sekolah',$item->id)}}" class="{{Request::is('/laporan/sekolah/'.$item->id) ? 'active' :''}}">{{$item->nama}}</a>
                </li>
                @endforeach
                <li class="{{Request::is('/laporan/rombel') ? 'active' :''}}">
                    <a href="{{route('laporan.rombel')}}" class="{{Request::is('/laporan/rombel') ? 'active' :''}}">Laporan Per Rombel</a>
                </li>
            </ul>
        </li>
        
        @endrole

        @role('koordinator halaqah')
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-layers"></i> <span>Halaqah</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                <li class="{{Request::routeIs('admin.halaqah.musyrif') ? 'active' :''}}">
                    <a href="{{route('admin.halaqah.musyrif')}}" class="{{Request::routeIs('admin.halaqah.musyrif') ? 'active' :''}}">Musyrif</a>
                </li>
                <li class="{{Request::routeIs('admin.halaqah.jadwal') ? 'active' :''}}">
                    <a href="{{route('admin.halaqah.jadwal')}}" class="{{Request::routeIs('admin.halaqah.jadwal') ? 'active' :''}}">Jadwal</a>
                </li>
                <li class="{{Request::routeIs('admin.halaqah.laporan') ? 'active' :''}}">
                    <a href="{{route('admin.halaqah.laporan')}}" class="{{Request::routeIs('admin.halaqah.laporan') ? 'active' :''}}">Laporan</a>
                </li>
                <li class="{{Request::routeIs('admin.halaqah.absen.today') ? 'active' :''}}">
                    <a href="{{route('admin.halaqah.absen.today')}}" class="{{Request::routeIs('admin.halaqah.absen.today') ? 'active' :''}}">Absen Hari Ini</a>
                </li>
                <li class="{{Request::routeIs('admin.halaqah.rekap') ? 'active' :''}}">
                    <a href="{{route('admin.halaqah.rekap')}}" class="{{Request::routeIs('admin.halaqah.rekap') ? 'active' :''}}">Rekap</a>
                </li>
                @php
                    $badgeComplain =\App\Models\Complainhalaqah::where('status',null)
                @endphp
                <li class="{{Request::routeIs('admin.halaqah.complain') ? 'active' :''}}">
                    <a href="{{route('admin.halaqah.complain')}}" class="{{Request::routeIs('admin.halaqah.complain') ? 'active' :''}}">
                        <span>
                            Complain Kehadiran
                            @if ($badgeComplain->count())
                            <span class="float-right badge badge-pill badge-primary">{{$badgeComplain->count()}}
                            @endif
                        </span>
                    </a>
                </li>
            </ul>
        </li>

        
        @endrole
        @role('admin')
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-security"></i> <span> Security </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                <li class="{{Request::routeIs('admin.security.lokasi') ? 'active' :''}}">
                    <a href="{{route('admin.security.lokasi')}}" class="{{Request::routeIs('admin.security.lokasi') ? 'active' :''}}">Lokasi</a>
                </li>
                <li class="{{Request::routeIs('admin.security.laporan') ? 'active' :''}}">
                    <a href="{{route('admin.security.laporan')}}" class="{{Request::routeIs('admin.security.laporan') ? 'active' :''}}">Laporan</a>
                </li>
            </ul>
        </li>
        @endrole

        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-printer"></i> <span>Cetak</span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                @role('guru')
                <li class="{{Request::routeIs('user.absen.jadwal') ? 'active' :''}}">
                    <a href="{{route('user.absen.jadwal')}}" class="{{Request::routeIs('user.absen.jadwal') ? 'active' :''}}">Roster</a>
                </li>
                @endrole
            </ul>
        </li>


        @role('piket')
        <li class="menu-title">Piket</li>
        <li>
            <a href="/piket/absen" class="waves-effect">
                <i class="mdi mdi-fingerprint"></i>
                <span>Absen Guru</span>
            </a>
        </li>
        <li>
            <a href="/piket/absen-alternatif" class="waves-effect">
                <i class="mdi mdi-cellphone"></i>
                <span>Absen Alternatif</span>
            </a>
        </li>
        @endrole

        @can('access-school-menu')
            <li class="menu-title">Kepala Sekolah</li>
            <li>
                <a href="/kepsek/rekap-absen-guru" class="waves-effect">
                    <i class="mdi mdi-chart-bar"></i>
                    <span> Rekap Mengajar </span>
                </a>
            </li>
            <li>
                <a href="/kepsek/absen-guru" class="waves-effect">
                    <i class="mdi mdi-history"></i>
                    <span> Riwayat Absen </span>
                </a>
            </li>
        @endcan
          

       



        @role('admin')
        

        <li class="menu-title">Sekolah</li>
        
        <li>
            <a href="/admin/sekolah" class="waves-effect">
                <i class="mdi mdi-bank"></i>
                <span> Sekolah </span>
            </a>
        </li>
        <li>
            <a href="/admin/semester" class="waves-effect">
                <i class="mdi mdi-calendar"></i>
                <span> Semester </span>
            </a>
        </li>
        
        
        
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-key"></i> <span> Manage User </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled">
                <li class="{{Request::routeIs('admin.user') ? 'active' :''}}">
                    <a href="{{route('admin.user')}}" class="{{Request::routeIs('admin.user') ? 'active' :''}}">User</a>
                </li>
                <li class="{{Request::routeIs('admin.user.role') ? 'active' :''}}">
                    <a href="{{route('admin.user.role')}}" class="{{Request::routeIs('admin.user.role') ? 'active' :''}}">Role Personal</a>
                </li>
            </ul>
        </li>

        @endrole

    </ul>
    <div class="mt-3 border-top">
        <div class="py-3 mb-5 text-center">
            <a href="#" target="_blank" rel="noopener noreferrer"><small>@Banbarossa</small></a>
        </div>
    </div>
</div>