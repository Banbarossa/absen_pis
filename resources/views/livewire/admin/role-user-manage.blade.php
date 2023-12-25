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
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Tambah Role</h4>
                        </div>
                        <div>
                            <form action="" wire:submit='addRole'>
                                <x-text-input-livewire type="text" name="tambahRoleName" label="Nama Role"></x-text-input-livewire>
                                <div class="form-group text-center row m-t-20">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light" >Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            {{-- non musyrif Area --}}
            <div class="col-lg-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="mt-0 header-title">Daftar User dengan Role <span class="text-primary">{{$roleName}}</span></h4>
                            
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
                                    @forelse ($users as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <div>{{$item->name}}</div>
                                                <small class="text-muted">{{$item->email}}</small>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm text-danger" wire:confirm='yakin untuk menghapus akses??' wire:click='revokeRole({{$item->id}})'><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Tidak Ada User dengan Role <span class="text-primary">{{$roleName}}</span></td>
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
                            @if (!empty($selectUsers))
                                <button type="button" class="btn btn-primary" wire:confirm='Apakah yakin Menambahkan data terpilih?' wire:click='addSelected'>
                                    Tambah Terpilih
                                </button>
                            @endif
                        </div>
                        <div>
                            <x-table-header pagination='perpage'/>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-sortable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th style="width: 110px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($userNotRole as $item)
                                        <tr>
                                            <td scope="row">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" wire:model.live='selectUsers' value='{{$item->id}}'  class="custom-control-input" id="customCheck{{$item->id}}">
                                                    <label class="custom-control-label" for="customCheck{{$item->id}}"></label>
                                                </div>
                                            </td>
                                            <td>{{$item->name}}</td>
                                            <td>
                                                <button type="button" class="dropdown-item" wire:confirm='Apakah Yakin menambahkan Guru' wire:click='assignSiggleRole({{$item->id}})'>
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
                                {{$userNotRole->links()}}
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
        







    </x-content-area>
</div>
