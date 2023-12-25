<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Rekap Absen</h4>
        </x-header>


        <div class="row">
            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mt-0 header-title">Rekap Kehadiran</h4>
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">Unduh Rekap Kehadiran</button>
                            </div>
                            <div class="d-flex align-items-center mb-2 justify-content-between">
                                
                                <div class="d-flex">
                                    <div class="form-group mr-2">
                                        <label for="startDate">Tanggal Awal</label>
                                        <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <label for="startDate">Tanggal akhir</label>
                                        <input type="date" wire:model.live="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">                   
                            <table class="table table-sm table-bordered ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Guru</th>
                                        <th>Total Hadir</th>
                                        <th>Total Sakit</th>
                                        {{-- <th>Total Izin</th> --}}
                                        <th>Total Izin Dinas</th>
                                        <th>Total Izin Pribadi</th>
                                        <th>Total Alpa</th>
                                        <th>Total Keterlambatan</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>

                                    @forelse ($sortedSummaryData as $key=> $summary)
                                    <tr>
                                        <td scope="row">{{$loop->iteration}}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#detailPersonal" wire:click='getDetailTeacher({{$summary['user_id']}})'>{{$summary['user_name'] ==0 ?'':$summary['user_name']}}</a>
                                            {{-- {{$summary['user_name'] ==0 ?'':$summary['user_name']}} --}}
                                        </td>
                                        <td>{{ $summary['total_hadir']  ==0 ?'':$summary['total_hadir']}}</td>
                                        <td>{{ $summary['totalSakit']  ==0 ?'':$summary['totalSakit']}}</td>
                                        {{-- <td>{{ $summary['total_izin']  ==0 ?'':$summary['total_izin']}}</td> --}}
                                        <td>{{ $summary['totalIzinDinas']  ==0 ?'':$summary['totalIzinDinas']}}</td>
                                        <td>{{ $summary['totalIzinPribadi']  ==0 ?'':$summary['totalIzinPribadi']}}</td>
                                        <td>{{ $summary['total_alpa']  ==0 ?'':$summary['total_alpa']}}</td>
                                        <td>{{ $summary['total_keterlambatan']  ==0 ?'':$summary['total_keterlambatan']}}</td>
                                       
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No Data Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        
            
        
        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card m-b-30 p-4">
                    <div class="card-header">
                        <h4 class="mt-0 header-title">Rekap Kehadiran</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Hadir</td>
                                    <th>{{ $counts['hadir']}} <small class="text-muted">Tatap Muka</small></th>
                                </tr>
                                <tr>
                                    <td>Sakit</td>
                                    <th>{{ $counts['sakit']}} <small class="text-muted">Tatap Muka</small></th>
                                </tr>
                                <tr>
                                    <td>Izin Dinas</td>
                                    <th>{{ $counts['izin dinas']}} <small class="text-muted">Tatap Muka</small></th>
                                </tr>
                                <tr>
                                    <td>Izin Pribadi</td>
                                    <th>{{ $counts['izin pribadi']}} <small class="text-muted">Tatap Muka</small></th>
                                </tr>
                                <tr>
                                    <td>Alpa</td>
                                    <th>{{ $counts['alpa']}} <small class="text-muted">Tatap Muka</small></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Detail Per Guru --}}
        @if ($user_id)
            @include('livewire.kepsek.part.show-detail-personal')            
        @endif


        <div class="modal fade bs-example-modal-lg" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5> --}}
                        <button class="btn btn-primary" onclick="generatePdf()">Unduh</button>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="pdf">
                        <div class="card m-b-30">
                            <div class="text-center mb-2">
                                <img src="{{asset('assets/images/logo.png')}}" height="60" alt="logo">
                                <h4 class="mt-0 header-title">REKAPITULASI DATA KEHADIRAN ASATIZAH</h4>
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
                                <h4 class="mt-0 header-title">A. Rekap Kehadiran</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Hadir</th>
                                            <th>Sakit</th>
                                            <th>Izin Dinas</th>
                                            <th>Izin Pribadi </th>
                                            <th>Alpa </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>{{ $counts['hadir']}} Tatap Muka</th>
                                            <th>{{ $counts['sakit']}} Tatap Muka</th>
                                            <th>{{ $counts['izin dinas']}} Tatap Muka</th>
                                            <th>{{ $counts['izin pribadi']}} Tatap Muka</th>
                                            <th>{{ $counts['alpa']}} Tatap Muka</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                        
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mt-0 header-title">B. Detail Kehadiran</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">                   
                                    <table class="table table-sm table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Guru</th>
                                                <th>Hadir</th>
                                                <th>Sakit</th>
                                                {{-- <th>Izin</th> --}}
                                                <th>Izin Dinas</th>
                                                <th>Izin Pribadi</th>
                                                <th>Alpa</th>
                                                <th>Keterlambatan</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
        
                                            @forelse ($sortedSummaryData as $key=> $summary)
                                            <tr>
                                                <td scope="row">{{$loop->iteration}}</td>
                                                <td>{{$summary['user_name'] ==0 ?'':$summary['user_name']}}</td>
                                                <td>{{ $summary['total_hadir']  ==0 ?'':$summary['total_hadir']}}</td>
                                                <td>{{ $summary['totalSakit']  ==0 ?'':$summary['totalSakit']}}</td>
                                                {{-- <td>{{ $summary['total_izin']  ==0 ?'':$summary['total_izin']}}</td> --}}
                                                <td>{{ $summary['totalIzinDinas']  ==0 ?'':$summary['totalIzinDinas']}}</td>
                                                <td>{{ $summary['totalIzinPribadi']  ==0 ?'':$summary['totalIzinPribadi']}}</td>
                                                <td>{{ $summary['total_alpa']  ==0 ?'':$summary['total_alpa']}}</td>
                                                <td>{{ $summary['total_keterlambatan']  ==0 ?'':$summary['total_keterlambatan']}}</td>
                                               
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