<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Kelola Asatizah</h4>
        </x-header>

        <div class="row">
            {{-- musyria Area --}}
            <div class="col-lg-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Kelola Asatizah</h4>
                        </div>
                        
                        <x-table-header/>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-sortable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>email</th>
                                        <th style="width: 110px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $pageNumber = ($guru->currentPage() - 1) * $guru->perPage();
                                    @endphp
                                    
                                    @forelse ($guru as $key => $item)
                                    <tr>
                                        <td scope="row">{{$pageNumber + $key + 1}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>
                                            <button type="button" class="dropdown-item" wire:confirm='Apakah Yakin menonaktifkan Guru' wire:click='revokeGuru({{$item->id}})'>
                                                <i class="fa fa-minus-square"></i>
                                                Nonaktifkan
                                            </button>
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
                            {{$guru->links()}}
                        </div>
        
                    </div>
                </div>
            </div>


            {{-- non musyrif Area --}}
            <div class="col-lg-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Tambah Guru</h4>
                            @if (!empty($selectUsers))
                                <button type="button" class="btn btn-primary" wire:confirm='Apakah yakin Menambahkan data terpilih?' wire:click='addSelected'>
                                    Tambah Terpilih
                                </button>
                            @endif
                        </div>

                        <x-table-header name='searchNonGuru' pagination='perPageNonGuru'/>
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
                                    
                                    @forelse ($nonGuru as $item)
                                    <tr>
                                        <td scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" wire:model.live='selectUsers' value='{{$item->id}}'  class="custom-control-input" id="customCheck{{$item->id}}">
                                                <label class="custom-control-label" for="customCheck{{$item->id}}"></label>
                                            </div>
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <button type="button" class="dropdown-item" wire:confirm='Apakah Yakin menambahkan Guru' wire:click='addGuru({{$item->id}})'>
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
                            {{$nonGuru->links()}}
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
        







    </x-content-area>
</div>
