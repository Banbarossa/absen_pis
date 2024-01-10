<div>
    <x-content-area>
        @php
        $hariMapping = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        @endphp
     
        <x-header>
            <h4 class="page-title">Laporan Kehadiran</h4>
        </x-header>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="mt-0 header-title">Periode</h4>
                            </div>
                            
                            {{-- <div class="d-flex">
                                <div class="form-group mr-2">
                                    <label for="startDate">Tanggal Awal</label>
                                    <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="startDate">Tanggal akhir</label>
                                    <input type="date" wire:model.live="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body min-vh-50">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">User</h4>
                            @if (!empty($selectAbsens))
                            <div class="btn-group show">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Aksi
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-4px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="#">Aprrove Terpilih</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#crudModal" href="#">Tolak Terpilih</a>
                                    <a class="dropdown-item" wire:confirm='Yakin untuk menghapus yang terseleksi?' wire:click='destroySelected' href="#">Hapus Terpilih</a>
                                </div>
                            </div>
                            
                            @endif
                        </div>
                        <div class="">
                           
                            
                            <x-table-header/>


                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nama Rombel</th>
                                            <th>Tanggal/Waktu</th>
                                            <th>Aproval</th>
                                            <th>Image</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($absens as $key=> $item)
                                            <tr>
                                                <td scope="row">
                                                    @if (is_null($item->approved))
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" wire:model.live='selectAbsens' value='{{$item->id}}'  class="custom-control-input" id="customCheck{{$item->id}}">
                                                        <label class="custom-control-label" for="customCheck{{$item->id}}"></label>
                                                    </div>
                                                        
                                                    @endif
                                                </td>
                                                <td>{{$item->user->name}}</td>
                                                <td>{{$item->rombel->nama_rombel}}</td>
                                                <td>
                                                    <div>
                                                        {{$item->tanggal}}
                                                    </div>
                                                    <small>{{$item->waktu_absen}}</small>
                                                </td>
                                                <td>
                                                    @if ($item->approved == 1)
                                                        <button disabled class="btn btn-sm btn-outline-success rounded-pill">Sudah Di Approve</button>
                                                    @elseif ($item->approved == null)
                                                        <button disabled class="btn btn-sm btn-primary rounded-pill">Belum Di Proses</button>
                                                    @else
                                                        <button disabled class="btn btn-sm btn-outline-danger rounded-pill">Sudah Di tolak</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->image)
                                                    <a href="{{asset('/storage/public/images/'.$item->image)}}" target="blank" class="thumbnail-link">
                                                        <img src="{{asset('/storage/public/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail">
                                                    </a>
                                                         
                                                                    
                                                    @endif
                                                </td>
                                                <td>
                                                   <button class="btn" wire:click='getAbsen({{$item->id}})'><i class="fa fa-eye"></i></button>
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
    
    
                                </table>

                            </div>
                            <div>
                                {{$absens->links()}}
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card m-b-30">
                    <div class="modal-content">
                        <div class="modal-body" id="pdf">
                            <div class="card m-b-30">
                                <div class="text-center mt-3">
                                    <h4 class="mt-0 header-title">Detail Absen Alternatif</h4>
                                </div>
                                @if ($singleAbsen)
                                    <div>
                                        <a href="{{asset('/storage/public/images/'.$singleAbsen->image)}}" target="blank" class="thumbnail-link">
                                            <img src="{{asset('/storage/public/images/'.$singleAbsen->image)}}" alt="Thumbnail Image" class="thumbnail">
                                        </a>
                                    </div>

                                    <div class="mt-3">
                                        <table>
                                            <tbody>

                                                <tr>
                                                    <td>Nama</td>
                                                    <td class="mx-2">:</td>
                                                    <td class="mx-2">{{$singleAbsen->user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jam Rombel</td>
                                                    <td class="mx-2">:</td>
                                                    <td class="mx-2">{{$singleAbsen->rombel->nama_rombel}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td class="mx-2">:</td>
                                                    <td class="mx-2">{{$singleAbsen->tanggal}} <small class="text-muted">{{$hariMapping[\Carbon\Carbon::parse($singleAbsen->tanggal)->dayOfWeek]}}</small></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Jam Absen</td>
                                                    <td class="mx-2">:</td>
                                                    <td class="mx-2">{{$singleAbsen->waktu_absen}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Alasan</td>
                                                    <td class="mx-2">:</td>
                                                    <td class="mx-2">{{$singleAbsen->alasan}}</td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                   
                                    
                                    @if (is_null($singleAbsen->approved))
                                    
                                    <div>
                                        <button type="button" class="btn btn-primary"  wire:click='terima({{$singleAbsen->id}})'>
                                            Terima
                                        </button>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#crudModal">
                                            Tolak
                                        </button>
                                        <button class="btn btn-danger" wire:confirm='Yakin untuk menghapus data?' wire:click='destroy({{$singleAbsen->id}})'>Hapus</button>
                                    </div>
                                    @endif
                                @else
                                    😎 Belum ada Data Yang dipilih
                                @endif
                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Penolakan --}}

                 <x-crud-modal title="Penolakan Absen Alternatif">
                    <div class="form-group">
                        <label for="alasan_penolakan">Alasan penolakan</label>
                        <textarea class="form-control @error('alasan_penolakan') is-invalid @enderror" id="alasan_penolakan" name="alasan_penolakan" rows="3"></textarea>
                        @error('alasan_penolakan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        @if (!empty($selectAbsens))
                        <button type="submit" wire:confirm='Yakin untuk menolak data?' wire:click='tolakSelected' class="btn btn-warning">Tolak</button>
                        @else
                            <button type="submit" wire:confirm='Yakin untuk menolak data?' wire:click='tolak' class="btn btn-primary">Tolak</button>
                        @endif
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </x-crud-modal>

    </x-content-area>

</div>