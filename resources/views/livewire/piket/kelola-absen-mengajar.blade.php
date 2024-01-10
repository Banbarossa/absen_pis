<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Absen Mengajar</h4>
        </x-header>


        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        {{-- table header --}}
                        <div class="d-flex align-items-center mb-2 justify-content-between">
                            <h4 class="mt-0 header-title">Daftar Absen Guru</h4>
                            
                        </div>

                        <div class="table-responsive">                   
                            <table class="table table-sm table-bordered ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Rombel</th>
                                        <th>Mapel</th>
                                        <th>Guru</th>
                                        <th>Status</th>
                                        <th>Waktu Absen</th>
                                        <th>Gambar</th>
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
                                            {{$item->tanggal}}
                                            <div>
                                                @if ($item->jam_ke == 'alternatif')
                                                    <small><a href="" wire:click='absenAlternatif({{$item->absenalternatif_id}})' data-toggle="modal" data-target="#alternatif">{{ucFirst($item->jam_ke)}}</a></small>
                                                @else
                                                <small class="text-muted">Jam Ke: {{$item->jam_ke}}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{$item->rombel->nama_rombel}}</td>
                                        <td>{{$item->mapel ? $item->mapel->mata_pelajaran :''}}</td>
                                        <td>{{$item->user ? $item->user->name :''}}</td>
                                        <td>
                                            @if ($item->kehadiran)
                                                {{ucFirst($item->kehadiran)}}</td>
                                            @else
                                                <span class="badge badge-warning py-2 px-3">Belum Absen</span>
                                            @endif
                                        <td>
                                            {{$item->waktu_absen}}
                                            @if ($item->keterlambatan > 0)
                                            <div><small class="text-muted">Terlambat: {{$item->keterlambatan }} Menit</small></div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->image)
                                            <a href="{{asset('/storage/public/images'.$item->image)}}" class="thumbnail-link">
                                                <img src="{{asset('/storage/public/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail">
                                            </a>
                                                 
                                                            
                                            @endif
                                        </td>
                                        <td>
                                            
                                            @role('admin')
                                                <button class="btn btn-outline-danger" wire:confirm='Apakah Yakin Mengahapus Data?' wire:click='destroy({{$item->id}})' >Hapus</button>
                                            @endrole
                                            @if ($item->kehadiran == 'alpa')
                                                <button class="btn btn-outline-warning" data-toggle="modal" data-target="#crudModal" wire:click='getAbsenSekolahId({{$item->id}})'>Aksi</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No Data Found</td>
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
            <form wire:submit='update'>
            <div>
                <div class="form-group">
                    <label for="change_to">Permohonan Ubah Ke</label>
                    <select wire:model='change_to' id="change_to" class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('change_to') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Perubahan Ke</option>
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


        {{-- Alasan menggunakan Absen Alternatif --}}
        <x-crud-modal title="Alasan" id="alternatif">
            <div>
                <p>{{$alasan}}</p>
            </div>
            
        </x-crud-modal>


        {{-- lightbox --}}
        @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
        <style>
            .thumbnail{
                height: 50px;
                width: 50px;
                object-fit: cover;
            }
        </style>
        
        @endpush
        @push('script')
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <script>
             $(document).ready(function() {
                $('.thumbnail-link').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
            });
        </script>
        
           
            
        @endpush
    </x-content-area>
</div>