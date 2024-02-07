<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Absen Halaqah</h4>
        </x-header>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6>Absen Hari Ini</h6>
                            <a href="{{route('cetak.jadwal-halaqah')}}" class="btn btn-primary d-inline-block ">Jadwal Halaqah</a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">                   
                            <table class="table table-sm table-bordered ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Jam Absen</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Aksi</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    @php
                                    $pageNumber = ($absen_hari_ini->currentPage() - 1) * $absen_hari_ini->perPage();
                                    $now = \Carbon\Carbon::now()->format('H:i:s');
                                    @endphp
        
                                    @forelse ($absen_hari_ini as $key=> $item)
                                    <tr>
                                        <td scope="row">{{$pageNumber + $key + 1}}</td>
                                        <td>
                                            <div>
                                                {{$item->tanggal}}
                                            </div>
                                            <div>
                                                <small class="text-muted">{{$item->jadwalhalaqah ? ucFirst($item->jadwalhalaqah->nama_sesi) :''}}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->waktu_absen)
                                                {{$item->waktu_absen}}
                                            @elseif(!$item->waktu_absen && $item->kehadiran == 'alpa' && $item->jadwalhalaqah->akhir_absen > $now )
                                                <div class="text-warning">Belum Absen</div>
                                            @else
                                                <div></div>
                                            @endif
                                        </td>
                                        <td>{{ucFirst($item->kehadiran)}}</td>
                                    
                                        <td>
                                            @if ($item->image)
                                                <a href="{{asset('storage/public/images/'.$item->image)}}" class="thumbnail-link">
                                                    <img src="{{asset('storage/public/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->kehadiran == 'alpa' && !$item->complainhalaqah && $item->jadwalhalaqah->akhir_absen < $now)
                                            <button class="btn btn-warning" wire:click='complain({{$item->id}})' data-toggle="modal" data-target="#crudModal">Complain</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No Data Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{$absen_hari_ini->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h6>Riwayat Absen</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group mr-2">
                                    <label for="startDate">Tanggal Awal</label>
                                    <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                               
                                <div class="form-group">
                                    <label for="startDate">Tanggal akhir</label>
                                    <input type="date" wire:model.live="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">                   
                            <table class="table table-sm table-bordered ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Jam Absen</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Aksi</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    @php
                                    $pageNumber = ($absens->currentPage() - 1) * $absens->perPage();
                                    @endphp
        
                                    @forelse ($absens as $key=> $item)
                                    <tr>
                                        <td scope="row">{{$pageNumber + $key + 1}}</td>
                                        <td>
                                            <div>
                                                {{$item->tanggal}}
                                            </div>
                                            <div>
                                                <small class="text-muted">{{$item->jadwalhalaqah ? ucFirst($item->jadwalhalaqah->nama_sesi) :''}}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->waktu_absen)
                                                {{$item->waktu_absen}}
                                            @elseif(!$item->waktu_absen && !$item->kehadiran )
                                                <div class="text-warning">Belum Absen</div>
                                            @else
                                                <div></div>
                                            @endif
                                        </td>
                                        <td>{{ucFirst($item->kehadiran)}}</td>
                                      
                                        <td>
                                            @if ($item->image)
                                                <a href="{{asset('storage/public/images/'.$item->image)}}" class="thumbnail-link">
                                                    <img src="{{asset('storage/public/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->kehadiran == 'alpa' && !$item->complainhalaqah)
                                            <button class="btn btn-warning" wire:click='complain({{$item->id}})' data-toggle="modal" data-target="#crudModal">Complain</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No Data Found</td>
                                        </tr>
                                    @endforelse
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

        
        
        


         {{-- Modal create Update --}}

        <x-crud-modal title="Complain Absen Halaqah">
            <form wire:submit='storeComplain'>
            <div>
                <div class="form-group">
                    <label for="change_to">Permohonan Ubah Ke</label>
                    <select wire:model='change_to' id="change_to" class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('change_to') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Perubahan Ke</option>
                        <option value="hadir">Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin dinas">Izin Dinas</option>
                        <option value="izin pribadi">Izin Pribadi</option>
                    </select>
                    @error('change_to')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="reason">Alasan</label>
                    <div>
                        <textarea  id='reason' wire:model='reason' class="form-control @error('reason') is-invalid @enderror" rows="5"></textarea>
                    </div>
                    @error('reason')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>           
            
        </x-crud-modal>





    </x-content-area>
</div>