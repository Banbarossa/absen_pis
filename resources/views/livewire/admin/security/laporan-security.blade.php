<div>
    <x-content-area>
     
        <x-header>
           
            <h4 class="page-title">Absen Karyawan</h4>
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
                            <button class="btn btn-primary" wire:click='unduhExcel'>Unduh Excel</button>
                            {{-- <a href="/user-unduh-jadwal-mengajar" class="btn btn-primary">Cetak Jadwal Mengajar Anda</a> --}}
                            <div class="d-flex">
                                <div class="form-group mr-2">
                                    <label for="startDate">Tanggal Awal</label>
                                    <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="endDate">Tanggal akhir</label>
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
                                        <th>Nama Lokasi</th>
                                        <th>Waktu Scan</th>
                                        <th>Dalam lokasi</th>
                                       
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    @php
                                    $pageNumber = ($models->currentPage() - 1) * $models->perPage();
                                    @endphp

                                    @forelse ($models as $key=> $item)
                                    <tr>
                                        <td scope="row">{{$pageNumber + $key + 1}}</td>
                                        <td>
                                            @if ($item->image)
                                                <a href="{{asset('storage/images/security').$item->image}}" class="thumbnail-link">
                                                    <img src="{{asset('storage/images/security'.$item->image)}}" alt="Thumbnail Image" class="thumbnail rounded-circle">
                                                </a>
                                                
                                            
                                                
                                            @endif
                                            {{$item->image}}
                                        </td>

                                        <td>{{$item->tanggal}}</td>
                                        <td>{{$item->securelocation->nama_lokasi}}</td>
                                        <td>{{$item->waktu_scan}}</td>
                                        <td>
                                            {{$item->in_location ? 'Ya' :'Tidak'}}
                                            <span class="ml-3"><a href="https://www.google.com/maps?q={{$item->latitude}},{{$item->longitude}}" target="blank">Lihat Lokasi</a></span>
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
                            {{$models->links()}}
                        </div>
                        
            
        
        
                    </div>
                </div>
            </div>
        </div>

        
        
        


         {{-- Modal create Update --}}

        <x-crud-modal title="Complain Absen Halaqah">
            <form wire:submit='storeComplain'>
                {{-- <div>
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
                </div> --}}
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