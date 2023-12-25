<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Absen Mengajar</h4>
        </x-header>


        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Riwayat Absen</h4>
                            
                        </div>
                        {{-- table header --}}
                        <div class="d-flex align-items-center mb-1 justify-content-between">
                            <a href="{{route('user.absen.jadwal')}}" class="btn btn-primary">Cetak Jadwal Mengajar Anda</a>
                            <div class="d-flex">
                                <div class="form-group mr-2">
                                    <label for="startDate">Tanggal Awal</label>
                                    <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                </div>
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
                                        <th>Gambar</th>
                                        <th>Tanggal</th>
                                        <th>Rombel</th>
                                        <th>Jam ke / Mapel</th>
                                        <th>Status</th>
                                        <th>Waktu Absen</th>
                                        <th>Keterlambatan</th>
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
                                            @if ($item->image)
                                                <a href="{{asset('storage/images/'.$item->image)}}" class="thumbnail-link">
                                                    <img src="{{asset('storage/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail rounded-circle">
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{$item->tanggal}}</td>
                                        <td>{{$item->rombel->nama_rombel}}</td>
                                        <td>
                                            <div>{{$item->jam_ke}}</div>
                                            <div><small>{{$item->mapel ? $item->mapel->mata_pelajaran : '' }}</small></div>
                                            
                                        </td>
                                        <td>{{ucFirst($item->kehadiran)}}</td>
                                        <td>{{$item->waktu_absen}}</td>
                                        <td>{{$item->keterlambatan}}</td>
                                        
                                        <td>
                                            @if ($item->kehadiran == 'alpa' && !$item->complainmengajar)
                                            <button class="btn btn-warning" wire:click='complain({{$item->id}})' data-toggle="modal" data-target="#crudModal">Complain</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">No Data Found</td>
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