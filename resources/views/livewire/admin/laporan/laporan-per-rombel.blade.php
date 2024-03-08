<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Rekap Absen</h4>
        </x-header>


        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="">
                            <div class="row">
                                <div class="col-12">
                                </div>
                            </div>
                            <div class="row">
                                <div class="gap-3 col-12 col-lg-6 d-flex">
                                    {{-- <button type="button" class="mr-2 btn btn-sm btn-primary waves-effect waves-light align-self-center" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">Unduh Rekap Kehadiran</button>
                                    <button type="button" wire:click='export' class="btn btn-sm btn-secondary waves-effect waves-light align-self-center">Unduh Excel</button> --}}
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="startDate">Tanggal Awal</label>
                                        <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="startDate">Tanggal akhir</label>
                                        <input type="date" wire:model.live="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach ($rombel as $item)
                                <li class="nav-item">
                                    <a class="nav-link {{ $rombel_id ==$item->id ?'text-primary':'' }}" wire:click='changeRombel({{ $item->id }})'>{{ $item->nama_rombel }}</a>
                                </li>
                                    
                                @endforeach
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="p-3" >
                                    <div class="table-responsive">                   
                                        <table class="table table-sm table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Guru</th>
                                                    <th>jam Ke</th>
                                                    <th>Mapel</th>
                                                    <th>Waktu Absen</th>
                                                    <th>Keterlambatan</th>
                                                    <th>Kehadiran</th>
                                                    <th>Gambar</th>
                                                    <th>Action</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody>

                                                @forelse ($absensekolah as $key=> $item)
                                                <tr>
                                                    <td scope="row font-weight-light">{{$loop->iteration}}</td>
                                                    <td scope="row font-weight-light">
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                                        </div>
                                                        <small>
                                                            {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->formatLocalized('%A') }}
                                                        </small>
                                                    </td>
                                                    <td>{{ $item->user ? $item->user->name :''}}</td>
                                                    <td>{{ $item->jam_ke }}</td>
                                                    <td>{{ $item->mapel ? $item->mapel->mata_pelajaran :'' }}</td>
                                                    <td>{{ $item->waktu_absen }}</td>
                                                    <td>{{ $item->keterlambatan }}</td>
                                                    <td>{{ $item->kehadiran }}</td>
                                                    <td>
                                                        @if ($item->image)
                                                        <a href="{{asset('storage/public/images/'.$item->image)}}" class="thumbnail-link">
                                                            <img src="{{asset('storage/public/images/'.$item->image)}}" alt="Thumbnail Image" class="thumbnail rounded-circle">
                                                        </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger" wire:confirm='Apakah Yakin untuk menghapus Data' wire:click='hapus({{ $item->id }})'>Hapus?</button>
                                                    </td>
                                                
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8">No Data Found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        {{$absensekolah->links()}}
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>





    </x-content-area>
    @push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">
    <style>
        .thumbnail{
            height: 50px;
            width: 50px;
            object-fit: cover;
        }
    </style>
    @endpush


    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <script>
        // magnifier image
         $(document).ready(function() {
            $('.thumbnail-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });


        // Genarate Pdf rekap
        function generatePdf(){

        const element = document.getElementById('pdf');
        var opt = {
            filename:     'Rekap Kehadiran.pdf',
            margin: 0.5,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

        html2pdf().set(opt).from(element).save();
        }

        // Genarate Detail
        function UnduhDetail(){

        const element = document.getElementById('UnduhDetail');
        var opt = {
            filename:     'Detail Kehadiran.pdf',
            margin: 0.5,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

        html2pdf().set(opt).from(element).save();
        }

    </script>
    


        

    @endpush

</div>