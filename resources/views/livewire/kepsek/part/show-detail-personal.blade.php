<div class="modal fade bs-example-modal-lg" id="detailPersonal" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5> --}}
                <button class="btn btn-primary" onclick="UnduhDetail()">Unduh</button>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="UnduhDetail">
                <div class="card m-b-30">
                    <div class="text-center mb-2">
                        <img src="{{asset('assets/images/logo.png')}}" height="60" alt="logo">
                        <h4 class="mt-0 header-title">DETAIL KEHADIRAN ASATIZAH</h4>
                        <h3 class="mt-0 header-title">PESANTREN IMAM SYAFI'I</h3>
                        <h4 class="mt-0 header-title">JENJANG {{strToUpper($sekolah->nama)}}</h4>
                        
                    </div>
                     <div class="title mt-3">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Periode</td>
                                    <td class="mx-2">:</td>
                                    <th>{{$startDate}} s/d {{$endDate}}</th>
                                </tr>
                            </tbody>
                        </table>
                     </div>
                </div>



                    
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="mt-0 header-title">{{$nama_guru}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">                   
                            <table class="table table-sm table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Tanggal</th>
                                        <th>Jam Pelajaran</th>
                                        <th>Waktu Absen</th>
                                        <th>Kehadiran</th>
                                        <th>Keterlambatan</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>

                                    @forelse ($details as $item)
                                    <tr>
                                       <td>
                                            @if ($item->image)
                                                <a href="{{asset('storage/images/'.$item->image)}}" class="thumbnail-link">
                                                    <img src="{{asset('storage/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail rounded-circle">
                                                </a>
                                            @endif
                                       </td>
                                       <td>{{$item->tanggal}}</td>
                                       <td>{{$item->jam_ke}}</td>
                                       <td>{{$item->waktu_absen}}</td>
                                       <td>{{$item->kehadiran}}</td>
                                       <td>{{$item->keterlambatan ? $item->keterlambatan." Menit" :'' }}</td>
                                       
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No Data Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

