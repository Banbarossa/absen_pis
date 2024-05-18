<div>
    <x-content-area>
        <x-header>
            <h4 class="page-title">{{ __('Jam Karyawan') }}</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="card">
                            <div class="px-4 py-1 card title">
                                <h5>Bagian</h5>
                                <button type="button" class="my-4 btn btn-outline-primary" data-toggle="modal" data-target="#crudModal" >
                                    Tambah Data
                                </button>
                            </div>
                            <div class="p-4 card-body">
                                <x-crud-modal title="Tambah Data">
                                    <form wire:submit='storeBagian'>
                                    <div>
                                        <div class="mt-4">
                                            <x-text-input-livewire
                                            label='Nama Bagian'
                                            name='name'
                                            wire:model='name'
                                            id='name'
                                            >
                                            </x-text-input-livewire>
                                            <x-text-input-livewire
                                            label='Latitude dan Logitude'
                                            name='lokasi'
                                            wire:model='lokasi'
                                            id='lokasi'
                                            >
                                            </x-text-input-livewire>
                                            <x-text-input-livewire
                                            label='Radius Absen'
                                            type="number"
                                            name='radius'
                                            wire:model='radius'
                                            id='radius'
                                            >
                                            </x-text-input-livewire>

                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </form>           
                                    
                                </x-crud-modal>
                                <ul class="list-unstyled d-flex">
                                    @forelse ($bagians as $item)
                                    <li class="mb-2 mr-2">
                                        <button class="d-block btn btn-{{ $bagianId == $item->id ? '':'outline-' }}success" wire:click='selectBagianId({{ $item->id }})'>{{ $item->name }}</button>
                                    </li>
                                    @empty
                                        <li>Tidak Ada Data Yang ditemukan</li>
                                    @endforelse
                                    
                                </ul>

                                @if ($bagianId == '')
                                Pilih Salah Satu Bagian
                                @else
                                @if (!$userbagian->isEmpty())
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-sortable">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th style="width: 110px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @forelse ($userbagian as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>
                                                    <button type="button" class="dropdown-item" wire:confirm='Apakah yakin mengeluarkan dari bagian ini' wire:click='kosongkanBagian({{$item->id}})'>
                                                        <i class="fa fa-minus-square"></i>
                                                        Hapus
                                                    </button>
                                                    
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <th colspan="">🙌 No Data Found</th>
                                            </tr>
                                                
                                            @endforelse
                    
                    
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                    
                                @endif
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="p-4 card">
                            <div class="card-title"></div>
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
                                                
                                                @forelse ($users as $item)
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
                                        {{$users->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                    </div>
                </div>
            </div>
        </div>
    </x-content-area>
</div>

