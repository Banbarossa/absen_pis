<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Dashboard</h4>
        </x-header>

        
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <h5 class="text-danger">
                        Pasword Absen : <strong>{{Auth::user()->password_absen}}</strong> 
                    </h5>
                </div>
            </div>
        </div>

        @if ($user->is_karyawan)
        <div class="row">
            <div class="col-12">
                <livewire:user.dashboard.absendinasluarlink/>
            </div>
        </div>
            
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Kalender Akademik
                    </div>
                    <div class="card-body">
                        <embed src="{{asset('kaldik.pdf')}}" type="application/pdf" width="100%" height="500" />
                    </div>
                </div>
            </div>
        </div>


        @if (auth()->user()->aksesabsens->contains('nama_akses', 'halaqah'))
        <div class="row">
            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <h4 class="mt-0 header-title">List Jadwal Halaqah</h4>
                            <a href="{{route('cetak.jadwal-halaqah')}}" class="btn btn-primary">Cetak Jadwal Halaqah</a>
                        </div>
                        <div class="table-responsive">                   
                            <table class="table table-sm table-bordered ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Jam Absen</th>
                                        <th>Status</th>
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
                                        <td>{{$item->tanggal}}</td>
                                        <td>
                                            @if ($item->waktu_absen)
                                                {{$item->waktu_absen}}
                                            @elseif(!$item->waktu_absen && !$item->status_kehadiran )
                                                <div class="text-warning">Belum Absen</div>
                                            @else
                                                <div></div>
                                            @endif
                                        </td>
                                        <td>{{ucFirst($item->kehadiran)}}</td>
                                        <td>
                                            @if ($item->kehadiran == 'alpa' && !$item->complainhalaqah)
                                            <button class="btn btn-warning" wire:click='complain({{$item->id}})' data-toggle="modal" data-target="#crudModal">Complain</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No Data Found</td>
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
            <div class="col-lg-4">
                <div class="p-4 card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Rekap Kehadiran Halaqah</h4>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Hadir</td>
                                    <th>{{ $countHalaqah['hadir']}}</th>
                                </tr>
                                <tr>
                                    <td>Sakit</td>
                                    <th>{{ $countHalaqah['sakit']}}</th>
                                </tr>
                                <tr>
                                    <td>Izin Dinas</td>
                                    <th>{{ $countHalaqah['izin_dinas']}}</th>
                                </tr>
                                <tr>
                                    <td>Izin Pribadi</td>
                                    <th>{{ $countHalaqah['izin_pribadi']}}</th>
                                </tr>
                                <tr>
                                    <td>Alpa</td>
                                    <th>{{ $countHalaqah['alpa']}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        
        
        


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

        {{-- modal jadwal --}}
        {{-- <x-crud-modal id="jadwalHalaqah" title="Complain Absen Halaqah">
            fgsfsgfsfsgs         
            
        </x-crud-modal> --}}





    </x-content-area>
</div>