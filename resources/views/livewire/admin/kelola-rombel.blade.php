<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Manajemen Rombel</h4>
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
                            Tambah Rombel
                        </button>
                    </div>
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="sort @if($sortColumn == 'sekolah_id') {{$sortDirection}} @endif" wire:click="sort('sekolah_id')">Nama Sekolah</th>
                                <th class="sort @if($sortColumn == 'nama_rombel') {{$sortDirection}} @endif" wire:click="sort('nama_rombel')">Nama Rombel</th>
                                <th class="sort @if($sortColumn == 'tingkat_kelas') {{$sortDirection}} @endif" wire:click="sort('tingkat_kelas')">Tingkat Kelas</th>
                                <th>Jadwal</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pageNumber = ($model->currentPage() - 1) * $model->perPage();
                            @endphp
                            
                            @forelse ($model as $key => $item)
                            <tr>
                                <td scope="row">{{$pageNumber + $key + 1}}</td>
                                <td>{{$item->sekolah ? $item->sekolah->nama :''}}</td>
                                <td>{{$item->nama_rombel}}</td>
                                <td>{{$item->tingkat_kelas}}</td>
                                <td>
                                    @forelse ($item->schedules as $schedule)
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-4" wire:click='editSchedule({{$item->id}})'>{{$schedule->name}}</button>

                                        @if ($rombel_id === $item->id && $openFormEdit)
                                        <form action="" wire:submit.prevent='updateSchedules'>
                                            <div class="input-group">
                                                <select class="custom-select @error('schedule_id') is-invalid @enderror" wire:model='schedule_id' id="inputGroupSelect04" aria-label="Example select with button addon">
                                                  <option selected>Choose...</option>
                                                  @foreach ($dataSchedules as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                  @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                  <button class="btn btn-outline-secondary" type="submit">Submit</button>
                                                </div>
                                              </div>
                                        </form>
                                        @endif


                                    @empty
                                    <div class="{{$rombel_id === $item->id && $openForm ? 'd-none' :''}}">
                                        <button class="btn btn-sm btn-outline-warning rounded-pill px-4" wire:click='pilihSchedule({{$item->id}})'>Pilih Jadwal</button>
                                    </div>
                                    @endforelse

                                    @if ($rombel_id === $item->id && $openForm)
                                        <form action="" wire:submit.prevent='saveSchedule'>
                                            <div class="input-group">
                                                <select class="custom-select @error('schedule_id') is-invalid @enderror" wire:model='schedule_id' id="inputGroupSelect04" aria-label="Example select with button addon">
                                                  <option selected>Choose...</option>
                                                  @foreach ($dataSchedules as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                  @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                  <button class="btn btn-outline-secondary" type="submit">Submit</button>
                                                </div>
                                              </div>
                                        </form>
                                    @endif
                                    
                                   
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if ($item->schedules->count() >0)
                                        <a href="{{route('pengajaran.detail.rombel',$item->id)}}" class="btn btn-sm btn-primary mr-3">Penjadwalan</a>
                                        @endif
                                        {{-- <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#crudModal" wire:click='edit({{$item->id}})'>
                                                    Edit
                                                </button>
                                                <button class="dropdown-item" wire:confirm="Are you sure you want to delete this post?" wire:click='destroy({{$item->id}})'>Delete</button>

                                            </div>
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="6">🙌 No Data Found</th>
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

        <x-crud-modal title="{{$rombel_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($rombel_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <div class="form-group">
                    <label for="sekolah_id">Sekolah</label>
                    <select wire:model.live='sekolah_id' class="select2 form-control custom-select select2-hidden-accessible @error('sekolah_id') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Sekolah</option>
                        @foreach ($sekolah as $item)
                            <option value="{{$item->id}}" >{{$item->nama}}</option>
                        @endforeach
                    </select>
                    @error('sekolah_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <x-text-input-livewire type="text" name="nama_rombel" label="Nama Rombel"></x-text-input-livewire>
                {{-- variabel kelas --}}
                @if ($getJenjangSekolah == 'sd')
                    @php
                        $tingkat=[1,2,3,4,5,6]
                    @endphp
                @elseif ($getJenjangSekolah == 'smp')
                    @php
                        $tingkat=[7,8,9]
                    @endphp
                @else
                    @php
                        $tingkat=[10,11,12]
                    @endphp        
                @endif
                {{-- end variable --}}
                
                <div class="form-group">
                    <label for="tingkat_kelas">Tingkat Kelas</label>
                    <select wire:model='tingkat_kelas' class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('tingkat_kelas') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Tingkat Kelas</option>
                        @foreach ($tingkat as $item)
                            <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                    </select>
                    @error('tingkat_kelas')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <x-text-input-livewire type="text" name="latitude" label="Latitude"></x-text-input-livewire>
                <x-text-input-livewire type="text" name="longitude" label="Longitude"></x-text-input-livewire>
                <x-text-input-livewire type="number" name="radius" label="radius"></x-text-input-livewire>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>           
            
        </x-crud-modal>

        {{-- cetak barcode --}}
        <div class="modal fade bs-example-modal-lg" id="cetakBarcode" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5> --}}
                        <button class="btn btn-primary" onclick="unduhRombel()">Unduh</button>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="unduhRombel">
                        @foreach ($model as $item)
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
                                            {!! QrCode::size(150)->generate(url('/').'/absen-mengajar/'.$item->kode_rombel) !!}
                                        </div>
                                        <a href="{{url('/absen-mengajar/'.$item->kode_rombel)}}" target="blank" class="px-5 mt-2 rounded-pill btn btn-outline-primary fw-bold">scan here</a>
                                        <div class="mt-3">
                                            {{$item->nama_rombel}}
                                        </div>
                                    </div>
                                   <h2 class="text-danger mt-5">Perhatian</h2>
                                   <ul>
                                        <li>Absen mula dapat diakses 10 Menit Sebelum mulai jam Pelajaran</li>
                                        <li>Absen berakhir 15 sebelum akhir jam Pelajaran</li>
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
                    /* background-color: maroon; */
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