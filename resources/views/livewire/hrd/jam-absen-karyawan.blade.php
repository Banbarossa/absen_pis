<div>
    <x-content-area>
        @php
        $hariMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        @endphp


        <x-header>
            <h4 class="page-title">{{ __('Jam Karyawan') }}</h4>
        </x-header>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                
                        <h4 class="mt-0 header-title">Justify Tabs</h4>
                        <p class="text-muted m-b-30 font-14">Use the tab JavaScript plugin—include
                            it individually or through the compiled <code class="highlighter-rouge">bootstrap.js</code>
                            file—to extend our navigational tabs and pills to create tabbable panes
                            of local content, even via dropdown menus.</p>

                        <!-- Nav tabs -->
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link {{ is_null($bagianId) ?'active' :''}}" data-toggle="tab" href="#home-1" role="tab"  wire:click='clearBagianUserId'>Home</a>
                            </li>
                            @foreach ($bagians as $item)
                            <li class="nav-item waves-effect waves-light" >
                                <a class="nav-link {{ $bagianId==$item->id ?'active':'' }}" wire:click='getBagianUserId({{ $item->id }})'>{{ $item->name }}</a>
                            </li>
                                
                            @endforeach
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="p-3 tab-pane active" id="home-1" role="tabpanel">
                                @if ($bagianId)
                                <div>
                                    <a href="{{ route('admin.pengaturan.jam-karyawan.create',$bagianId) }}" class="my-4 btn btn-outline-primary">Tambah Jam Absen</a>
                                </div>
                                    
                                @endif
                                <table class="table table-sm table-bordered table-sortable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bagian</th>
                                            <th class="sort @if($sortColumn == 'nama_jam_kerja') {{$sortDirection}} @endif" wire:click="sort('nama_jam_kerja')">Nama Jam Kerja</th>
                                            <th class="sort @if($sortColumn == 'jam_masuk_1') {{$sortDirection}} @endif" wire:click="sort('jam_masuk_1')">Jam Masuk 1</th>
                                            <th class="sort @if($sortColumn == 'jam_masuk_2') {{$sortDirection}} @endif" wire:click="sort('jam_masuk_2')">Jam Masuk 2</th>
                                            <th class="sort @if($sortColumn == 'jam_pulang') {{$sortDirection}} @endif" wire:click="sort('jam_pulang')">Jam Pulang</th>
                                            <th class="sort @if($sortColumn == 'toleransi') {{$sortDirection}} @endif" wire:click="sort('toleransi')">Toleransi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $pageNumber = ($models->currentPage() - 1) * $models->perPage();
                                        @endphp
                                        
                                        @forelse ($models as $key => $item)
                                        <tr>
                                            <td scope="row">{{$pageNumber + $key + 1}}</td>
                                            <td>{{ucFirst($item->bagianuser ? $item->bagianuser->name :'')}}</td>
                                            <td>{{ucFirst($item->nama_jam_kerja)}}</td>
                                            <td>
                                                <div class="fw-bold">{{$item->jam_masuk_1}}</div>
                                                <div>
                                                    <small class="text-muted">Mulai Akses Absen :{{$item->mulai_absen_masuk_1}}</small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Akhir Akses Absen :{{$item->akhir_absen_masuk_1}}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{$item->jam_masuk_2}}</div>
                                                <div>
                                                    <small class="text-muted">Mulai Akses Absen :{{$item->mulai_absen_masuk_2}}</small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Akhir Akses Absen :{{$item->akhir_absen_masuk_2}}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{$item->jam_pulang}}</div>
                                                <div>
                                                    <small class="text-muted">Mulai Akses Absen :{{$item->mulai_absen_pulang}}</small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Akhir Akses Absen :{{$item->akhir_absen_pulang}}</small>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->toleransi ? $item->toleransi.' Menit':'' }}
                                                <div>
                                                    <small>
                                                        Absen Pulang hari Berikutnya? :{{ $item->ischeckouttomorrow ?'Ya':'Tidak' }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="{{ route('admin.pengaturan.jam-karyawan.update',$item->id) }}" class="dropdown-item">Edit</a>
                                                        <button type="button" class="dropdown-item" wire:click='destroy({{$item->id}})'>
                                                            Hapus
                                                        </button>
            
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <th colspan="7">🙌 No Data Found</th>
                                        </tr>
                                            
                                        @endforelse
                                    </tbody>
                                </table>

                                {{ $models->links() }}
                            </div>
                                
                        </div>

                    </div>
                </div>
            </div>

         {{-- Modal create Update --}}

        {{-- <x-crud-modal title="{{$jamkerja_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($jamkerja_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <x-text-input-livewire type="text" name="nama_jam_kerja" label="Nama Jadwal"></x-text-input-livewire>
                <div class="mt-3 text-center title"><h5>Masuk</h5></div>
                <x-text-input-livewire type="time" name="jam_masuk" label="Jam Masuk"></x-text-input-livewire>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-text-input-livewire type="time" name="mulai_absen_masuk" label="Mulai Absen Masuk"></x-text-input-livewire>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-text-input-livewire type="time" name="akhir_absen_masuk" label="Akhir Absen Masuk"></x-text-input-livewire>
                    </div>
                </div>
                <hr>
                <div class="mt-3 text-center title"><h5>Pulang</h5></div>
                <x-text-input-livewire type="time" name="jam_pulang" label="Jam Pulang"></x-text-input-livewire>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-text-input-livewire type="time" name="mulai_absen_pulang" label="Mulai Absen Pulang"></x-text-input-livewire>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-text-input-livewire type="time" name="akhir_absen_pulang" label="Akhir Absen Pulang"></x-text-input-livewire>
                    </div>
                </div>

                <hr>
                <div class="mt-3 text-center title"><h5>Dispensasi</h5></div>
                <x-text-input-livewire type="number" name="toleransi" label="Toleransi Keterlambatan (Menit)"></x-text-input-livewire>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>           
            
        </x-crud-modal> --}}

        {{-- Barcode
        <div class="modal fade bs-example-modal-lg" id="cetakBarcode" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn btn-primary" onclick="unduhRombel()">Unduh</button>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="unduhRombel">
                        <div class="card m-b-30 my-bg">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h1 class="fw-bold" style="font-size: 4rem">ABSENSI</h1>
                                    <p style="font-size: 2rem" class=" fw-light text-primary">DIGITAL</p>
                                </div>
                                <div>
                                    <img src="{{asset('assets/images/logo.png')}}" height="60" alt="logo">
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top:8rem">
                                <div class="text-center col-5">
                                    <img src="{{asset('assets/images/hero-img.png')}}" class="img-fluid" alt="">
                                </div>
                                <div class="align-middle col-7">
                                    <div class="text-center">
                                        <div>
                                            {!! QrCode::size(150)->generate(url('/absen-kesantrian')) !!}
                                        </div>
                                        <a href="{{url('/absen-kesantrian/')}}" target="blank" class="px-5 mt-2 rounded-pill btn btn-outline-primary fw-bold">scan here</a>
                                        <div class="mt-3">
                                            Absen Kesantrian
                                        </div>
                                    </div>
                                   <h2 class="mt-5 text-danger">Perhatian</h2>
                                   <ul>
                                        <li>Absen dapat dilakukan sesuai dengan waktu yang telah ditentukan</li>
                                        <li class="fw-bold">Aktifkan Gps sebelum absen</li>
                                        <li>Pasktikan anda selfi di wilayah yang dapat diverifikasi</li>
                                   </ul>
                                </div>
                                
                            </div>
                            <div class="py-4" style="margin-top:8rem">
                                <div class="d-flex justify-content-between align-item-center text-primary">
                                    <div><i class="ml-1 fa fa-instagram"></i><i class="ml-1 fa fa-facebook"></i><i class="ml-1 fa fa-youtube"></i><i class="ml-1 fa fa-telegram"></i><a href="" class="ml-2">imamsyafiisibreh</a></div>
                                    <div><i class="fa fa-home"></i><a href="" class="ml-2">pis.sch.id</a></div>
                                    <div><i class="fa fa-facebook"></i><a href="" class="ml-2">Departemen Pendidikan PIS Sibreh</a></div>
                                    
                                </div>
                            </div>

                        </div>
                        <div style="page-break-before: always"></div>
                        
                        
                    </div>
                </div>
            </div>
        </div> --}}




    </x-content-area>
</div>