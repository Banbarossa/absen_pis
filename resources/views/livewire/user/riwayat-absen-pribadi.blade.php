<div class="row">
    <div class="col-12">
        <div class="bg-white card m-b-30">
            <div class="card-body new-user">
                    <h5 class="mt-0 mb-4 header-title">Riwayat Absen</h5>
                <ul class="pr-3 mb-0 list-unstyled" id="boxscroll2" tabindex="1" style="overflow: hidden; outline: none;">
                    @forelse ($models as $item)
                    <li class="p-3">
                        <div class="media">
                            <div class="float-left thumb">
                                <a href="{{asset('storage/public/images/karyawan/'. $item->image)}}">
                                    <img class=" rounded-circle" src="{{asset('storage/public/images/karyawan/'. $item->image)}}" alt="Img">
                                </a>
                            </div>
                            <div class="media-body">
                                <p class="mb-0 media-heading">{{ ucWords(str_replace('_',' ',$item->type)) }} <i class="mr-1 fa fa-circle text-success pull-right"></i></p>
                                <small class="pull-right text-muted">{{ $item->jam }}</small>
                                <small class="text-muted"><a href="https://www.google.com/maps?q={{ $item->lokasi }}" target="blank">Lihat Lokasi</a></small>
                            </div>
                        </div>
                    </li>
                    @empty
                        
                    @endforelse
                </ul>                                    
            </div>                                
        </div>
    </div>
</div>