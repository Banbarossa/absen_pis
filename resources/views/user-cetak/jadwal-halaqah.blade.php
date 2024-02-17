<x-app-layout>


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
            <h4 class="page-title">Schedule</h4>
        </x-header>


        {{-- Jadwal Jam --}}
        <div class="mb-4 d-flex justify-content-between">
            <button type="button" onclick="generatePdf()" class="btn btn-primary">
                Cetak Jadwal
            </button>
        </div>

        <div class="p-5 overflow-auto bg-secondary" style="height: 400px">
            <div id='pdf' class="p-5 bg-white">
                <h3 class="text-center m-b-15">
                    <a href="https:/pis.sch.id" class="logo logo-admin"><img src="{{asset('assets/images/logo.png')}}" height="100" alt="logo"></a>
                </h3>
                <div class="mb-5 text-center">
                    <h5>JADWAL HALAQAH {{ strtoupper(config('app.instansi_name')) }}</h5>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Sesi</th>
                                <th>Jam Mulai Absen</th>
                                <th>Akhir Absen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwals as $hari => $items)
                            <tr>
                                <td rowspan="{{ count($items) }}">{{ $hariMapping[$hari] }}</td>
                                @foreach ($items as $key => $item)
                                    @if ($key > 0)
                                        <tr>
                                    @endif
                                    <td>{{ ucfirst($item->nama_sesi) }}</td>
                                    <td>{{ $item->mulai_absen }}</td>
                                    <td>{{ $item->akhir_absen }}</td>
                                    @if ($key > 0)
                                        </tr>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                            
                        </tbody>
                    </table>
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
                filename:     'Jadwal_halaqah.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                };

            html2pdf().set(opt).from(element).save();
        }

    </script>
        
    @endpush
</x-app-layout>
        




    
