<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Lokasi Absen Security</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List Rombel</h4>
                    <div>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cetakBarcode ">
                            Cetak barcode
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crudModal">
                            Tambah User
                        </button>
                    </div>
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="sort @if($sortColumn == 'nama_lokasi') {{$sortDirection}} @endif" wire:click="sort('nama_lokasi')">Nama Lokasi</th>
                                <th >Kode Lokasi</th>
                                <th class="sort @if($sortColumn == 'start_scan') {{$sortDirection}} @endif" wire:click="sort('start_scan')">Scan Scan</th>
                                <th class="sort @if($sortColumn == 'end_scan') {{$sortDirection}} @endif" wire:click="sort('end_scan')">End Scan</th>
                                <th class="sort @if($sortColumn == 'latitude') {{$sortDirection}} @endif" wire:click="sort('latitude')">Latitude</th>
                                <th class="sort @if($sortColumn == 'longitude') {{$sortDirection}} @endif" wire:click="sort('longitude')">Longitude</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pageNumber = ($lokasi->currentPage() - 1) * $lokasi->perPage();
                            @endphp
                            
                            @forelse ($lokasi as $key => $item)
                            <tr>
                                <td scope="row">{{$pageNumber + $key + 1}}</td>
                                <td>{{$item->nama_lokasi}}</td>
                                <td>{{$item->kode_lokasi}}</td>
                                <td>{{$item->start_scan}}</td>
                                <td>{{$item->end_scan}}</td>
                                <td>{{$item->latitude}}</td>
                                <td>{{$item->longitude}}</td>
                                <td>
                                    <div class="d-flex">
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
                    {{$lokasi->links()}}
                </div>

            </div>
        </div>


         {{-- Modal create Update --}}

        <x-crud-modal title="{{$secure_lokasi_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($secure_lokasi_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>


                <x-text-input-livewire type="text" name="nama_lokasi" label="Nama Lokasi"></x-text-input-livewire>
                <x-text-input-livewire type="time" name="start_scan" label="start_scan"></x-text-input-livewire>
                <x-text-input-livewire type="time" name="end_scan" label="end_scan"></x-text-input-livewire>
                <x-text-input-livewire type="number" name="latitude" label="Latitude"></x-text-input-livewire>
                <x-text-input-livewire type="number" name="longitude" label="Longitude"></x-text-input-livewire>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>           
            
        </x-crud-modal>

        {{-- cetak barcode --}}
        <div class="modal fade bs-example-modal-lg" id="cetakBarcode" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn btn-primary" onclick="unduhRombel()">Unduh</button>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="unduhRombel">
                        @foreach ($lokasi as $item)
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
                                            {!! QrCode::size(150)->generate(url('/').'/absen-security/'.$item->kode_lokasi) !!}
                                        </div>
                                        <a href="{{url('/absen-security/'.$item->kode_lokasi)}}" target="blank" class="px-5 mt-2 rounded-pill btn btn-outline-primary fw-bold">scan here</a>
                                        <div class="mt-3">
                                            {{strToUpper($item->nama_lokasi)}}
                                        </div>
                                    </div>
                                   <h2 class="text-danger mt-5">Perhatian</h2>
                                   <ul>
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
                            
                        @endforeach


                            
                     
                        
                    </div>
                </div>
            </div>
        </div>


        @push('style')
            <style>
                
                .footer-barcode{
                    margin-top: 8rem;
                    height: 6rem;
                }
            </style>
        @endpush
        @push('script')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>

                function unduhRombel(){

                    const element = document.getElementById('unduhRombel');
                    var opt = {
                        filename:     'barcode.pdf',
                        margin: 0.5,
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2 },
                        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                        };

                    html2pdf().set(opt).from(element).save();
                }

            </script>
        @endpush


    </x-content-area>
    

</div>