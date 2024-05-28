<div>
    <x-content-area>
        @php
        $hariMapping = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        @endphp
     
        <x-header>
            <h4 class="page-title">Laporan Kehadiran</h4>
        </x-header>
        <div class="mb-3 row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-6">
                                <h4 class="mt-0 header-title">Periode</h4>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="mr-2 form-group">
                                    <label for="startDate">Tanggal Awal</label>
                                    <input type="date" wire:model.live="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="startDate">Tanggal akhir</label>
                                    <input type="date" wire:model.live="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">User</h4>
                        </div>
                        <div class="text-center form-group row m-t-20">
                            @foreach ($users as $item)
                            <div class="mt-2 col-12 d-flex">
                                <button class="btn btn-{{$user_id == $item->id ? 'primary':'outline-secondary'}} btn-block waves-effect waves-light" wire:click='rekap({{$item->id}})'>{{ucFirst($item->name)}}</button>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                {{-- <div class="card m-b-30">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-selected="true">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Profile</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="p-3 tab-pane active" id="home" role="tabpanel">
                                <livewire:hrd.detail-laporan.absen-karyawan-detail
                                    :startDate="$startDate"
                                    :endDate="$endDate"
                                    :userId="$user_id"
                                />
                            </div>
                            <div class="p-3 tab-pane" id="profile" role="tabpanel">
                                
                            </div>
                        </div>

                    </div>
                </div> --}}











                <div class="card m-b-30">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- <h5 class="mt-0 modal-title" id="myLargeModalLabel">Large modal</h5> --}}
                            <button class="btn btn-primary" onclick="generatePdf()">Unduh</button>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body" id="pdf">
                            <div class="card">
                                <div class="text-center">
                                    <img src="{{asset('assets/images/logo.png')}}" height="60" alt="logo">
                                    <h4 class="mt-0 header-title">Rekap Kehadiran Mengajar Dan Halaqah</h4>
                                </div>
                                 <div class="mt-3 title">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Periode</td>
                                                <td class="pl-3">:</td>
                                                <th class="pl-3">{{\Carbon\Carbon::parse($startDate)->format('d-m-Y')}} s/d {{\Carbon\Carbon::parse($endDate)->format('d-m-Y')}}</th>
                                            </tr>
                                            <tr>
                                                <td>Nama Guru</td>
                                                <td class="pl-3">:</td>
                                                <th class="pl-3">{{$guru ? $guru->name :''}}</th>
                                            </tr>
                                            <tr>
                                                <td>Total honor</td>
                                                <td class="pl-3">:</td>
                                                <th class="pl-3" id="totalJumlah"></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                 </div>
                            </div>
    
                            {{-- Rekap Guru --}}
                            @if ($guru && $guru->hasRole('guru'))
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mt-0 header-title">☑️ Rekap Mengajar</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        @foreach ($rekapDataPerSekolah as $namaSekolah => $rekapSekolah)
                                                        <tr>
                                                            <th colspan="4">{{ $namaSekolah }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Hadir Mengajar</td>
                                                            <th>{{ $rekapSekolah['hadir_mengajar'] }} <small class="ml-2 text-muted">JP</small></th>
                                                            <td>{{ number_format($rekapSekolah['honor'],0,',','.') }}</td>
                                                            <td class="jumlah">{{ number_format($rekapSekolah['honor'] * $rekapSekolah['hadir_mengajar'], 0, ',', '.')}}</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Izin Dinas</td>
                                                            <th>{{ $rekapSekolah['izin_dinas_mengajar'] }}<small class="ml-2 text-muted">JP</small></th>
                                                            <td>{{ number_format($rekapSekolah['honor'],0,',','.') }}</td>
                                                            <td class="jumlah">{{ number_format($rekapSekolah['honor'] * $rekapSekolah['izin_dinas_mengajar'], 0, ',', '.')}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Izin Pribadi</td>
                                                            <th>{{ $rekapSekolah['izin_pribadi_mengajar'] }}<small class="ml-2 text-muted">JP</small></th>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sakit</td>
                                                            <th>{{ $rekapSekolah['sakit_mengajar'] }}<small class="ml-2 text-muted">JP</small></th>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alpa</td>
                                                            <th>{{ $rekapSekolah['alpa_mengajar'] }}<small class="ml-2 text-muted">JP</small></th>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                           
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mt-0 header-title">☑️ Jumlah Hari Hadir</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Jumlah hari Mengajar</td>
                                                            <th>{{$jumlahHarihadir}}<small class="ml-2 text-muted">Hari</small></th>
                                                            <td>20.000</td>
                                                            <td>{{ number_format(20000 * $jumlahHarihadir, 0, ',', '.')}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                           
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            @endif
                            
                            

                            {{-- Rekap Halaqah --}}
                            @if ($guru && $guru->hasRole('musyrif halaqah'))
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mt-0 header-title">☑️ Rekap Halaqah</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">

                                                <table class="table table-sm">
                                            
                                                    <tbody>
                                                        <tr>
                                                            <td>Hadir</td>
                                                            <th>{{ $hadir_halaqah}} <small class="ml-3 text-muted"> X - Tatap Muka</small></th>
                                                            <td>........................................................</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Izin Dinas</td>
                                                            <th>{{ $izin_dinas_halaqah}} <small class="ml-3 text-muted"> X - Tatap Muka</small></th>
                                                            <td>........................................................</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Izin Pribadi</td>
                                                            <th>{{ $izin_pribadi_halaqah}} <small class="ml-3 text-muted"> X - Tatap Muka</small></th>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sakit</td>
                                                            <th>{{ $sakit_halaqah}} <small class="ml-3 text-muted"> X - Tatap Muka</small></th>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alpa</td>
                                                            <th>{{ $alpa_halaqah}} <small class="ml-3 text-muted"> X - Tatap Muka</small></th>
                                                            <td></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            @endif


                            {{-- Detail Mengajar --}}
                            @if ($guru && $guru->hasRole('guru'))
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
                                                    <th>nama</th>
                                                    <th>Tanggal</th>
                                                    <th>Rombel/Jam Ke</th>
                                                    <th>Waktu Absen</th>
                                                    <th>Kehadiran</th>
                                                    <th>Jumlah Jam</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                             
            
                                                @forelse ($absen_mengajar as $key=> $item)
                                                <tr>
                                                   
                                                    <td scope="row">{{$loop->iteration}}</td>
                                                    <td>{{$item->user->name}}</td>
                                                    <td>
                                                        <div>{{\Carbon\Carbon::parse($item->tanggal)->format('d-m-Y')}} <small>{{$hariMapping[\Carbon\Carbon::parse($item->tanggal)->dayOfWeek]}}</small></div>
                                                        
                                                    </td>
                                                    <td>{{$item->rombel->nama_rombel}} <span class="ml-3">{{$item->jam_ke}}</span></td>
                                                    <td>{{$item->waktu_absen}}</td>
                                                    <td class="{{$item->kehadiran != 'hadir' ?'text-warning':''}}">{{ucFirst($item->kehadiran)}}</td>
                                                    <td>{{$item->jumlah_jam}}</td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7">No Data Found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                
                            @endif
                            
                            {{-- Detail Halaqah --}}
                            @if ($guru && $guru->hasRole('musyrif halaqah'))
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mt-0 header-title">B. Detail Kehadiran</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">                   
                                        <table class="table table-sm table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>jadwal Halaqah</th>
                                                    <th>Tanggal</th>
                                                    <th>Hari</th>
                                                    <th>Waktu Absen</th>
                                                    <th>Kehadiran</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                             
            
                                                @forelse ($halaqah as  $item)
                                                <tr>
                                                   
                                                    <td>{{ucFirst($item->jadwalhalaqah ? $item->jadwalhalaqah->nama_sesi :'')}}</td>
                                                    <td>{{$item->tanggal}}</td>
                                                    <td>{{$hariMapping[\Carbon\Carbon::parse($item->tanggal)->dayOfWeek]}}</td>
                                                    <td>{{$item->waktu_absen}}</td>
                                                    <td>{{ucFirst($item->kehadiran)}}</td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6">No Data Found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                
                            @endif
                            
                                
                            
                            
                            
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
                jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
                };

            html2pdf().set(opt).from(element).save();
        }


        $(document).ready(function(){
            var totalJumlah = 0;

            $('.jumlah').each(function(){
                var nilai = $(this).text().replace(/\D/g,''); // Menghapus karakter non-digit
                totalJumlah += parseInt(nilai);
            });
            
            var formattedTotalJumlah = formatRupiah(totalJumlah, 'Rp ');

            console.log('total: '.totalJumlah)

            $('#totalJumlah').text(totalJumlah);

            function formatRupiah(angka, prefix){
                var reverse = angka.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return prefix + ribuan;
            }
        
    });

    </script>
@endpush

</div>