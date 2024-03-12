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
            0 => 'Minggu',
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
                                <th class="sort @if($sortColumn == 'hari') {{$sortDirection}} @endif" wire:click="sort('hari')">Hari</th>
                                <th class="sort @if($sortColumn == 'nama_sesi') {{$sortDirection}} @endif" wire:click="sort('nama_sesi')">Nama Sesi</th>
                                <th class="sort @if($sortColumn == 'mulai_absen') {{$sortDirection}} @endif" wire:click="sort('mulai_absen')">Jam Mulai Absen</th>
                                <th class="sort @if($sortColumn == 'akhir_absen') {{$sortDirection}} @endif" wire:click="sort('akhir_absen')">Jam Akhir Absen</th>
                                {{-- <th class="sort @if($sortColumn == 'insentif') {{$sortDirection}} @endif" wire:click="sort('insentif')">Besaran Insentif</th> --}}
                                <th>Active</th>
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
                                <td>{{$hariMapping[$item->hari]}}</td>
                                <td>{{ucFirst($item->nama_sesi)}}</td>
                                <td>{{$item->mulai_absen}}</td>
                                <td>{{$item->akhir_absen}}</td>
                                <td>
                                    <button class="btn btn-sm {{ $item->is_aktif ? 'btn-success':'btn-warning' }}" wire:confirm='Apakah Yakin untuk menruhah keaktifan?' wire:click='changeAktif({{ $item->id }})'>{{ $item->is_aktif ?'Aktif':'Tidak Aktif' }}</button>
                                </td>
                                {{-- <td>{{$item->insentif ? 'Rp '.number_format($item->insentif, 0, ',', '.') : ''}}</td> --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#crudModal" wire:click='edit({{$item->id}})'>
                                                Edit Jadwal
                                            </button>
                                            <button class="dropdown-item" wire:confirm="Are you sure you want to delete this post?" wire:click='destroy({{$item->id}})'>Delete</button>

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
                </div>
               

                <div>
                    {{$model->links()}}
                </div>

            </div>
        </div>


         {{-- Modal create Update --}}

        <x-crud-modal title="{{$jadwal_halaqah_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($jadwal_halaqah_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <div class="form-group">
                    <label for="hari">Pilih Hari</label>
                    <select wire:model='hari' class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('hari') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Hari</option>
                        @foreach ($hariMapping as $key => $item)
                            <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                    @error('hari')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <x-text-input-livewire type="text" name="nama_sesi" label="Nama Sesi"></x-text-input-livewire>
                <x-text-input-livewire type="time" name="mulai_absen" label="Mulai Absen"></x-text-input-livewire>
                <x-text-input-livewire type="time" name="akhir_absen" label="Akhir Absen"></x-text-input-livewire>
                <x-text-input-livewire type="number" name="insentif" label="Besaran Insentif"></x-text-input-livewire>
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
                        {{-- <h5 class="mt-0 modal-title" id="myLargeModalLabel">Large modal</h5> --}}
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
                                            {!! QrCode::size(150)->generate(url('/absen-halaqah')) !!}
                                        </div>
                                        <a href="{{url('/absen-halaqah/')}}" target="blank" class="px-5 mt-2 rounded-pill btn btn-outline-primary fw-bold">scan here</a>
                                        <div class="mt-3">
                                            Absen Halaqah
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
        </div>





    </x-content-area>
</div>