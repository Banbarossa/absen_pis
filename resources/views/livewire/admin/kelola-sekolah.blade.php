<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Manajemen Sekolah</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List Sekolah</h4>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crudModal">
                        Tambah User
                    </button>
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="sort @if($sortColumn == 'npsn') {{$sortDirection}} @endif" wire:click="sort('npsn')">NPSN</th>
                                <th class="sort @if($sortColumn == 'nama') {{$sortDirection}} @endif" wire:click="sort('nama')">Nama Sekolah</th>
                                <th class="">Jejang</th>
                                <th class="">Kepala Sekolah</th>
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
                                <td>{{$item->npsn}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{strToUpper($item->jenjang)}}</td>
                                <td>{{$item->user ? $item->user->name:''}}</td>
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

        <x-crud-modal title="{{$sekolah_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($sekolah_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <x-text-input-livewire type="text" name="npsn" label="NPSN"></x-text-input-livewire>
                <x-text-input-livewire type="text" name="nama" label="Nama Sekolah"></x-text-input-livewire>
                <div class="form-group">
                    <label for="user_id">Kepala Sekolah</label>
                    <select wire:model='user_id' class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('user_id') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Kepala Sekolah</option>
                        @foreach ($users as $item)
                            <option value="{{$item->id}}" >{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jenjang">Jenjang Sekolah</label>
                    <select wire:model='jenjang' class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('jenjang') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Jenjang</option>
                        <option value="sd" >SD</option>
                        <option value="smp" >SMP</option>
                        <option value="sma" >SMA</option>
                    </select>
                    @error('jenjang')
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