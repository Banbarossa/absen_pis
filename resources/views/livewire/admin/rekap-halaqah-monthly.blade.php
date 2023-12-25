<div>
    <x-content-area>
        @php
        $hariMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        @endphp
     
        <x-header>
            <h4 class="page-title">Rekap Kehadiran Halaqah</h4>
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
                                        <th>Total Izin Dinas</th>
                                        <th>Total Izin Pribadi</th>
                                        <th>Total Alpa</th>
                                        <th>Detail</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>

                                    @forelse ($rekap_data as $key=> $summary)
                                    <tr>
                                        <td scope="row">{{$loop->iteration}}</td>
                                        <td>{{$summary->user_name ==0 ?'':$summary->user_name}}</td>
                                        <td>{{$summary->hadir ==0 ?'':$summary->hadir}}</td>
                                        <td>{{$summary->sakit ==0 ?'':$summary->sakit}}</td>
                                        <td>{{$summary->izin_dinas ==0 ?'':$summary->izin_dinas}}</td>
                                        <td>{{$summary->izin_pribadi ==0 ?'':$summary->izin_pribadi}}</td>
                                        <td>{{$summary->alpa ==0 ?'':$summary->alpa}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" wire:click='detail({{$summary->user_id}})' data-toggle="modal" data-animation="bounce" data-target="#modalDetail">Detail</button>
                                        </td>
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
                                    <th>{{ $rekapTotal->total_hadir}}</th>
                                </tr>
                                <tr>
                                    <td>Sakit</td>
                                    <th>{{ $rekapTotal->total_sakit}}</th>
                                </tr>
                                <tr>
                                    <td>Izin Dinas</td>
                                    <th>{{ $rekapTotal->total_izin_dinas}}</th>
                                </tr>
                                <tr>
                                    <td>Izin Pribadi</td>
                                    <th>{{ $rekapTotal->total_izin_pribadi}}</th>
                                </tr>
                                <tr>
                                    <td>Alpa</td>
                                    <th>{{ $rekapTotal->total_alpa}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        

    
        {{-- Modal Rekap Kehadiran --}}
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
                                <h4 class="mt-0 header-title">REKAPITULASI DATA KEHADIRAN HALAQAH</h4>
                                
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
                                            <th>{{ $rekapTotal->total_hadir}}</th>
                                            <th>{{ $rekapTotal->total_sakit}}</th>
                                            <th>{{ $rekapTotal->total_izin_dinas}}</th>
                                            <th>{{ $rekapTotal->total_izin_pribadi}}</th>
                                            <th>{{ $rekapTotal->total_alpa}}</th>
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
                                                <th>Izin Dinas</th>
                                                <th>Izin Pribadi</th>
                                                <th>Alpa</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
        
                                            @forelse ($rekap_data as $key=> $summary)
                                            <tr>
                                                <td scope="row">{{$loop->iteration}}</td>
                                                <td>{{$summary->user_name ==0 ?'':$summary->user_name}}</td>
                                                <td>{{$summary->hadir ==0 ?'':$summary->hadir}}</td>
                                                <td>{{$summary->sakit ==0 ?'':$summary->sakit}}</td>
                                                <td>{{$summary->izin_dinas ==0 ?'':$summary->izin_dinas}}</td>
                                                <td>{{$summary->izin_pribadi ==0 ?'':$summary->izin_pribadi}}</td>
                                                <td>{{$summary->alpa ==0 ?'':$summary->alpa}}</td>
                                               
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

        {{-- Modal detail By User --}}
        <div class="modal fade bs-example-modal-lg" id="modalDetail" wire:ignore.self tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5> --}}
                        <button class="btn btn-primary" onclick="unduhPdf()">Unduh</button>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="byMusyrif">
                        <div class="card m-b-30">
                            <div class="text-center mb-2">
                                <img src="{{asset('assets/images/logo.png')}}" height="60" alt="logo">
                                <h4 class="mt-0 header-title">Riwayat Absensi halaqah</h4>
                                
                            </div>
                             <div class="title mt-3">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Periode</td>
                                            <td class="mx-2">:</td>
                                            <th>{{$startDate}} s/d {{$endDate}}</th>
                                        </tr>
                                        <tr>
                                            <td>Nama Musyrif Halaqah</td>
                                            <td class="mx-2">:</td>
                                            <th>{{$musyrifName}}</th>
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
                                            <th>{{ $hadir}}</th>
                                            <th>{{ $sakit}}</th>
                                            <th>{{ $izin_dinas}}</th>
                                            <th>{{ $izin_pribadi}}</th>
                                            <th>{{ $alpa}}</th>
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
                                                <th>jadwal Halaqah</th>
                                                <th>Tanggal</th>
                                                <th>Hari</th>
                                                <th>Waktu Absen</th>
                                                <th>Kehadiran</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                         
        
                                            @forelse ($absenPerMusyrif as $key=> $item)
                                            <tr>
                                               
                                                <td scope="row">{{$loop->iteration}}</td>
                                                <td>{{ucFirst($item->jadwalhalaqah ? $item->jadwalhalaqah->nama_sesi :'')}}</td>
                                                <td>{{$item->tanggal}}</td>
                                                <td>{{$hariMapping[\Carbon\Carbon::parse($item->tanggal)->dayOfWeek]}}</td>
                                                <td>{{$item->waktu_absen}}</td>
                                                <td>{{ucFirst($item->kehadiran)}}</td>
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

    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

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

        function unduhPdf(){

            const element = document.getElementById('byMusyrif');
            var opt = {
                filename:     'Riwayat Absen.pdf',
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