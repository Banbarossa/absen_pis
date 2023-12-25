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
            <h4 class="page-title">Kelola Jadwal Halaqah</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List Jadwal Halaqah</h4>
                    <div>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cetakBarcode ">
                            Cetak barcode
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crudModal">
                            Tambah Jadwal Halaqah
                        </button>
                    </div>
                </div>

                
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                       

                                <th>#</th>
                                <th class="sort @if($sortColumn == 'nama_jam_kerja') {{$sortDirection}} @endif" wire:click="sort('nama_jam_kerja')">Nama Jadwal</th>
                                <th class="sort @if($sortColumn == 'jam_masuk') {{$sortDirection}} @endif" wire:click="sort('jam_masuk')">Jam Masuk</th>
                                <th class="sort @if($sortColumn == 'jam_pulang') {{$sortDirection}} @endif" wire:click="sort('jam_pulang')">Jam Pulang</th>

                                <th class="sort @if($sortColumn == 'mulai_absen_masuk') {{$sortDirection}} @endif" wire:click="sort('mulai_absen_masuk')">Mulai Absen Masuk</th>
                                <th class="sort @if($sortColumn == 'mulai_absen_pulang') {{$sortDirection}} @endif" wire:click="sort('mulai_absen_pulang')">Mulai Absen Pulang</th>
                                <th class="sort @if($sortColumn == 'toleransi') {{$sortDirection}} @endif" wire:click="sort('toleransi')">Toleransi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pageNumber = ($model->currentPage() - 1) * $model->perPage();
                            @endphp
                            
                            @forelse ($model as $key => $item)
                            <tr>
                               
                                <td scope="row">{{$pageNumber + $key + 1}}</td>
                                <td>{{ucFirst($item->nama_jam_kerja)}}</td>
                                <td>{{$item->jam_masuk}}</td>
                                <td>{{$item->jam_pulang}}</td>
                                <td>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                          Mulai Absen Masuk
                                          <span class="badge bg-primary rounded-pill py-1 text-white">{{$item->mulai_absen_masuk}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                          Akhir Absen Masuk
                                          <span class="badge bg-primary rounded-pill py-1 text-white">{{$item->akhir_absen_masuk}}</span>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                          Mulai Absen Pulang
                                          <span class="badge bg-primary rounded-pill py-1 text-white">{{$item->mulai_absen_pulang}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                          Akhir Absen Pulang
                                          <span class="badge bg-primary rounded-pill py-1 text-white">{{$item->akhir_absen_pulang}}</span>
                                        </li>
                                    </ul>
                                </td>
                                <td>{{$item->toleransi}}</td>
                                {{-- <td>{{$item->insentif ? 'Rp '.number_format($item->insentif, 0, ',', '.') : ''}}</td> --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#crudModal" wire:click='edit({{$item->id}})'>
                                                Edit
                                            </button>
                                            <button class="dropdown-item" wire:confirm="Are you sure you want to delete this post?" wire:click='destroy({{$item->id}})'>Delete</button>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="10">🙌 No Data Found</th>
                            </tr>
                                
                            @endforelse
    
    
                        </tbody>
                    </table>
                </div>
               

                <div>
                    {{$model->links()}}
                </div>

            </div>
        </div>


         {{-- Modal create Update --}}

        <x-crud-modal title="{{$jamkerja_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($jamkerja_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <x-text-input-livewire type="text" name="nama_jam_kerja" label="Nama Jadwal"></x-text-input-livewire>
                <div class="title text-center mt-3"><h5>Masuk</h5></div>
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
                <div class="title text-center mt-3"><h5>Pulang</h5></div>
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
                <div class="title text-center mt-3"><h5>Dispensasi</h5></div>
                <x-text-input-livewire type="number" name="toleransi" label="Toleransi Keterlambatan (Menit)"></x-text-input-livewire>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>           
            
        </x-crud-modal>

        {{-- Barcode --}}
        <div class="modal fade bs-example-modal-lg" id="cetakBarcode" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5> --}}
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
                                <div class="col-5 text-center">
                                    <img src="{{asset('assets/images/hero-img.png')}}" class="img-fluid" alt="">
                                </div>
                                <div class="col-7 align-middle">
                                    <div class="text-center">
                                        <div>
                                            {!! QrCode::size(150)->generate(url('/absen-kesantrian')) !!}
                                        </div>
                                        <a href="{{url('/absen-kesantrian/')}}" target="blank" class="px-5 mt-2 rounded-pill btn btn-outline-primary fw-bold">scan here</a>
                                        <div class="mt-3">
                                            Absen Kesantrian
                                        </div>
                                    </div>
                                   <h2 class="text-danger mt-5">Perhatian</h2>
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
        </div>





    </x-content-area>
</div>