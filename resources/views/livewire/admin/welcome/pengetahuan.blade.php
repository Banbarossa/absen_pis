<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Informasi</h4>
        </x-header>

        <div class="row">
            <div class="col-lg-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Pengetahuan</h4>
                            <a href="{{route('pengajaran.pengetahuan.create')}}" class="btn btn-primary">Tambah Data</a>
                        </div>
                        @if ($info)
                        <h5>{{$info->title}}</h5>
                        <small class="text-muted">{{\Carbon\Carbon::parse($info->created_at)->diffForHumans()}}</small>
                        
                        <div class="mt-3">{!! $info->content !!}</div>
                        @else
                            <p>Tidak Ada Data</p>
                        @endif
                        
        
        
                    </div>
                    <div class="card-footer">
                        @if ($info)
                        <a href="{{route('pengajaran.pengetahuan.update',$info->id)}}" class="btn btn-secondary">Edit</a>
                        <button class="btn btn-danger" wire:confirm='Apakah Yakin untuk menghapus??' wire:click='destroy({{$info->id}})'>Hapus</button>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-lg-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Latest</h4>
                        </div>

                        @forelse ($infos as $item)
                        <div class="card shadow mt-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>{{$item->title}}</h6>
                                    <div>
                                        <small class="text-muted">{{\Carbon\Carbon::parse($info->created_at)->diffForHumans()}}</small>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    {!!$item->content!!}
                                </div>
                                <a href="{{route('pengajaran.pengetahuan.update',$item->id)}}" class="btn btn-sm btn-outline-warning"><i class=" mdi mdi-pencil"></i></a>
                                <button class="btn btn-sm btn-outline-danger" wire:click='destroy({{$item->id}})' wire:confirm='Apakah yakin untuk menghapus'><i class=" mdi mdi-delete"></i></button>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-warning">
                            <p>Tidak Ada Data</p>
                        </div>
                            
                        @endforelse
                           
                        
                        <div class="mt-2">
                            {{$infos->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        







    </x-content-area>
</div>
