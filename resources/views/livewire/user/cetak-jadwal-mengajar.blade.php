<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Cetak Jadwal Mengajar</h4>
        </x-header>


        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div id="pdf">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="mt-0 header-title"></h4>
                                
                            </div>
                            {{-- table header --}}
                            <div class="d-flex align-items-center mb-2 justify-content-between">
                                <button type="button" onclick="generatePdf()" class="btn btn-primary">
                                    Cetak Jadwal Mengajar
                                </button>
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card bg-secondary p-4 overflow-auto" style="height: 500px">
                    <div class="card-body">
                        <div class="bg-white p-5" id='pdf'>
                            {{-- header --}}
                            <h3 class="text-center m-b-15">
                                <a href="https:/pis.sch.id" class="logo logo-admin"><img src="{{asset('assets/images/logo.png')}}" height="100" alt="logo"></a>
                            </h3>
                            <div class="text-center mb-5">
                                <h5>JADWAL PELAJARAN PESANTREN IMAM SYAFI'I</h5>
                                <h5>{{$semester}} {{$tahun_ajaran}}</h5>
                            </div>

                            <div>
                                <p>Nama Guru : <strong>{{$userName}}</strong></p>
                            </div>                          
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Hari</th>
                                            <th>Jam Ke</th>
                                            <th>Mulai KBM</th>
                                            <th>Akhir KBM</th>
                                            <th>Mata Pelajaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rosters as $roster)
                                        <tr>
                                            <td>{{$roster->jammengajar->hari}}</td>
                                            <td>{{$roster->jammengajar->jam_ke}}</td>
                                            <td>{{$roster->jammengajar->mulai_kbm}}</td>
                                            <td>{{$roster->jammengajar->akhir_kbm}}</td>
                                            <td>{{$roster->mapel->mata_pelajaran}}</td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            

        </div>

        @push('script')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>

                function generatePdf(){

                    const element = document.getElementById('pdf');
                    var opt = {
                        filename:     'Jadwal_mengajar.pdf',
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2 },
                        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                        };

                    html2pdf().set(opt).from(element).save();
                }

            </script>
        @endpush
        
    </x-content-area>
</div>