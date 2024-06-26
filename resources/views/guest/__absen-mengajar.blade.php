<x-guest-layout>
    <x-form-card>


        <div class="p-3">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($absen && $absen->kehadiran !== "hadir")
            <div class="mb-4 text-center">
                <h4>Konfirmasi Mengajar</h4>
            </div>
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td>Rombel</td>
                        <th>{{$absen->rombel->nama_rombel}}</th>
                    </tr>
                    <tr>
                        <td>Nama guru</td>
                        <th>{{$absen->user->name}}</th>
                    </tr>
                    <tr>
                        <td>Jam Ke</td>
                        <th>{{$absen->jam_ke}}</th>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <th>{{$absen->mapel->mata_pelajaran}}</th>
                    </tr>
                </tbody>
            </table>
            <form class="form-horizontal m-t-20" method="POST" action="{{route('absen-mengajar.store',$absen->id)}}">
            
                @csrf
                <div class="text-center form-group row m-t-20">
                    <div class="col-6">
                        <div id="my_camera"></div>
                        
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-6">
                        <div id="results" class="text-center text-muted">Hasil Capture</div>
                    </div>
                  
                    <div class="mt-3 col-12">
                        <input type=button class="btn btn-sm btn-outline-success" value="Take Snapshot" onClick="take_snapshot()">
                    </div>
                   
                </div>

                {{-- <x-text-input label="Id Rombel" name="id_rombel"  type="hidden" /> --}}
                <input type="hidden" name="id_rombel" value="{{$id_rombel}}">
                <input type="hidden" id="latitudeInput" name="latitude">
                <input type="hidden" id="longitudeInput" name="longitude">
                <x-text-input label="Password Absen Anda" name="password_absen" type="text" />


                
                <div class="text-center form-group row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Absen Sekarang</button>
                    </div>
                </div>

                <div class="mb-0 form-group m-t-10 row">
                    <div class="col-12 m-t-20">
                        <a href="{{route('absen-pengganti.index',$id_rombel)}}" class="text-muted"><i class="mdi mdi-barcode-scan"></i> <small>Saya Pengganti Guru Utama?</small></a>
                    </div>
                    {{-- <div class="col-sm-12 m-t-20">
                        <a href="{{route('absen-alternatif.index',$id_rombel)}}" class="text-muted"><i class="mdi mdi-barcode-scan"></i> <small>Absen dengan cara lain?</small></a>
                    </div> --}}
                    
                </div>
            </form>

            @elseif ($absen && $absen->kehadiran == 'hadir')
            <div class="mb-4 text-center">
                <h4>✍️Anda Sudah melakukan Absen pada jam {{$absen->waktu_absen ? $absen->waktu_absen :''}}</h4>
            </div>
            @else
            <div class="alert alert-danger">
                Tidak Ada Jadwal Pembelajaran yang ditemukan
            </div>
            <div class="col-sm-7 m-t-20">
                <a href="{{route('absen-alternatif.index',$id_rombel)}}" class="text-muted"><i class="mdi mdi-barcode-scan"></i> <small>Absen dengan cara lain?</small></a>
            </div>
            
            @endif

            
        </div>

    </x-form-card>


    @if ($absen &&$absen->kehadiran !== "hadir")
         @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script>
        Webcam.set({
            width: 180,
            height: 160,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
    
        Webcam.attach( '#my_camera' );
    
        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                // document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '" style="height: 160px; width: 120px; object-fit:cover;"/>';
            } );
        }

        function getLocation() {
          if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var latitude = position.coords.latitude;
              var longitude = position.coords.longitude;
        
              // Isi nilai input dengan latitude dan longitude
              document.getElementById("latitudeInput").value = latitude;
              document.getElementById("longitudeInput").value = longitude;
            }, function(error) {
              console.error("Gagal mengambil lokasi:", error.message);
            });
          } else {
            alert("Browser Anda tidak mendukung geolokasi.");
          }
        }
        
        // Panggil getLocation() saat halaman selesai dimuat
        window.onload = function() {
          getLocation();
        };
    </script>
        
    @endpush
    @endif
   

</x-guest-layout>