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
            <h4 class="page-title">Kelola Absen Halaqah</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List Jadwal Halaqah</h4>
                    <div>
                        <button type="button" class="btn btn-secondary mr-3" wire:click='exportExcel'>
                            Export
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table-header/>
                <div class="row">
                    <div class="col-6 col-md-4 offset-md-4 col-lg-3 offset-lg-6">
                        <div class="form-group mr-2">
                            <label for="startDate">Tanggal Awal</label>
                            <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="startDate">Tanggal akhir</label>
                            <input type="date" wire:model.live="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="sort @if($sortColumn == 'name') {{$sortDirection}} @endif" wire:click="sort('name')">Nama</th>
                                <th class="sort @if($sortColumn == 'tanggal') {{$sortDirection}} @endif" wire:click="sort('tanggal')">Tanggal</th>
                                <th class="sort @if($sortColumn == 'waktu_absen') {{$sortDirection}} @endif" wire:click="sort('mulai_absen')">Waktu Absen</th>
                                <th>Status</th>
                                {{-- <th>Lokasi</th> --}}
                                <th>Foto</th>
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
                                {{-- <td>{{$user_idMapping[$item->tanggal]}}</td> --}}
                                <td>{{ucFirst($item->user->name)}}</td>
                                <td>
                                    <div>{{$item->tanggal}}</div>
                                    <div><small class="text-muted">{{ucFirst($item->jadwalhalaqah ? $item->jadwalhalaqah->nama_sesi :'')}}</small></div>
                                </td>
                                <td>{{$item->waktu_absen}}</td>
                                <td>
                                    @if ($item->kehadiran)
                                        {{ucFirst($item->kehadiran)}}
                                    @else
                                        <div class="badge bg-warning py-1 px-3 text-white">
                                            Belum Absen
                                        </div>
                                    @endif
                                </td>
                                {{-- <td>
                                    @if (!is_null($item->in_location))
                                        <a href="https://www.google.com/maps?q={{$item->latitude}},{{$item->longitude}}" target="_blank">{{$item->in_location ? 'Dalam Lokasi':'Luar Lokasi'}}</a>
                                    @endif
                                </td> --}}
                                <td>
                                    @if ($item->image)
                                        <a href="{{asset('storage/public/images/'.$item->image)}}" class="thumbnail-link">
                                            <img src="{{asset('storage/public/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#crudModal" wire:click='edit({{$item->id}})'>
                                                Edit
                                            </button>

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

        <x-crud-modal title="Update Data Kehadiran">
      
            <form wire:submit='update'>
                <div>
                    <div class="form-group">
                        <label for="kehadiran">Ubah menjadi</label>
                        <select wire:model='kehadiran' id="kehadiran" class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('kehadiran') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                            <option>Perubahan Ke</option>
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin dinas">Izin Dinas</option>
                            <option value="izin pribadi">Izin Pribadi</option>
                        </select>
                        @error('kehadiran')
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