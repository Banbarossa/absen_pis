<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Pengaturan Semester</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List Sekolah</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crudModal">
                        Tambah
                    </button>
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="sort @if($sortColumn == 'tahun') {{$sortDirection}} @endif" wire:click="sort('tahun')">Tahun</th>
                                <th class="sort @if($sortColumn == 'nama_semester') {{$sortDirection}} @endif" wire:click="sort('nama_semester')">Semester</th>
                                <th class="">Status</th>
                                <th style="width: 110px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pageNumber = ($model->currentPage() - 1) * $model->perPage();
                            @endphp
                            
                            @forelse ($model as $key => $item)
                            <tr>
                                <td scope="row">{{$pageNumber + $key + 1}}</td>
                                <td>{{$item->tahun}}</td>
                                <td>{{$item->nama_semester}}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <button class="btn btn-sm btn-success" disabled>Aktif</button>
                                    @else
                                        <button wire:click='aktifkan({{$item->id}})' wire:confirm='Apakah anda yakin mengaktifkan semester ini' class="btn btn-sm btn-outline-warning">Tidak Aktif</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#crudModal" wire:click='edit({{$item->id}})'>
                                                Edit User
                                            </button>
                                            <button class="dropdown-item" wire:confirm="Are you sure you want to delete this post?" wire:click='destroy({{$item->id}})'>Delete</button>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4">🙌 No Data Found</th>
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

        <x-crud-modal title="{{$semester_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($semester_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <div class="form-group">
                    <label for="user_id">Semester</label>
                    <select wire:model='nama_semester' class="select2 form-control custom-select select2-hidden-accessible @error('nama_semester') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Semester</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                    @error('nama_semester')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="tahun">Tahun Ajaran</label>
                    <input type="text" wire:model="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Tahun Ajaran">
                    @error('tahun')
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