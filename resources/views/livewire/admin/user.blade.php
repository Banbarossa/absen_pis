<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">User Management</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List User</h4>
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Tambah User
                    </button> --}}
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="sort @if($sortColumn == 'name') {{$sortDirection}} @endif" wire:click="sort('name')">Nama User</th>
                                <th class="sort @if($sortColumn == 'email') {{$sortDirection}} @endif" wire:click="sort('email')">Email</th>
                                <th>Pw Absen</th>
                                <th>Status</th>
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
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->password_absen}}</td>
                                <td>
                                    @if ($item->status ==  1)
                                        <button class="btn btn-sm btn-outline-success rounded-pill" style="width: 100px" wire:confirm='Apakah Yakin untuk menonaktifkan user ini?' wire:click='nonAktifUser({{$item->id}})'>Aktif</button>
                                    @else
                                        <button class="btn btn-sm btn-outline-warning rounded-pill" style="width: 100px" wire:confirm='Apakah Yakin untuk mengaktifkan user ini?'  wire:click='aktif({{$item->id}})'>Tidak Aktif</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#exampleModal" wire:click='edit({{$item->id}})'>
                                                Edit User
                                            </button>
                                            <button type="button" class="dropdown-item btn btn-sm btn-danger" wire:confirm='Apakah Yakin untuk menghapus user ini? ' wire:click='destroy({{$item->id}})'>
                                                Hapus User
                                            </button>
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


         {{-- Modal create --}}
         <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="" wire:submit='updateUser'>
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                            <x-text-input-livewire type="text" name="name" label="Nama User"></x-text-input-livewire>
                            <x-text-input-livewire type="text" name="email" label="Nama User"></x-text-input-livewire>

                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>


          @push('script')
                <script>
                    console.log('test')
                </script>
          @endpush
    </x-content-area>
</div>
