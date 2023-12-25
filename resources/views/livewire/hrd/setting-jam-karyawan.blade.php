<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">User Role</h4>
        </x-header>

        <div class="row">
            {{-- musyria Area --}}
            <div class="col-lg-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Role</h4>
                        </div>
                        <div class="form-group text-center row m-t-20">
                            @foreach ($roles as $item)
                            <div class="col-12 mt-2 d-flex">
                                <button class="btn btn-{{$roleName == $item->name ? 'primary':'outline-secondary'}} btn-block waves-effect waves-light" wire:click='changeRole({{$item->id}})'>{{ucFirst($item->name)}}</button>
                                <button class="btn btn-sm text-danger" wire:confirm='yakin untuk menghapus role, Pastikan tidak ada data user di role ini??' wire:click='destroyRole({{$item->id}})'><i class="fa fa-trash-o"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            {{-- non musyrif Area --}}
            <div class="col-lg-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="mt-0 header-title">Jam Absensi <span class="text-primary">{{$role_jam->name}}</span></h4>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($role_jam->jamkaryawans as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_jam_kerja}}</div>
                                            <td>
                                                <button class="btn btn-sm text-danger" wire:confirm='yakin untuk menghapus akses??' wire:click='detachRole({{$item->id}})'><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Belum Ada Jam Absen <span class="text-primary">{{$roleName}}</span></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

        
    
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Tambah Role</h4>
                           
                        </div>
                        <div>
                            <x-table-header pagination='perpage'/>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-sortable">
                                    <thead>
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th>Nama</th>
                                            <th style="width: 110px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($jamkaryawan as $item)
                                        <tr>
                                          
                                            <td>{{ucFirst($item->nama_jam_kerja)}}</td>
                                            <td>
                                                <button type="button" class="dropdown-item" wire:confirm='Apakah Yakin menambahkan Guru' wire:click='attachjam({{$item->id}})'>
                                                    <i class="fa fa-plus-square"></i>
                                                    Tambah
                                                </button>
                                                
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <th colspan="3">🙌 No Data Found</th>
                                        </tr>
                                            
                                        @endforelse
                
                
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{$jamkaryawan->links()}}
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
        







    </x-content-area>
</div>
