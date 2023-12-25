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
            
            <div class="text-center mb-4">
                <h4>{{$lokasi->nama_lokasi}}</h4>
                <h4>{{$lokasi->start_scan}}</h4>
                <h4>{{$lokasi->end_scan}}</h4>
            </div>


            @if ($ontime)
            <form class="form-horizontal m-t-20" method="POST" action="{{route('absen-security.store',$lokasi->kode_lokasi)}}">
            
                @csrf
                <div class="form-group text-center row m-t-20">
                    <div class="col-6">
                        <div id="my_camera"></div>
                        
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-6">
                        <div id="results" class="text-muted text-center">Hasil Capture</div>
                    </div>
                  
                    <div class="col-12 mt-3">
                        <input type=button class="btn btn-sm btn-outline-success" value="Take Snapshot" onClick="take_snapshot()">
                    </div>
                   
                </div>

                <input type="hidden" id="latitudeInput" name="latitude">
                <input type="hidden" id="longitudeInput" name="longitude">
                <x-text-input label="Password Absen Anda" name="password_absen" type="text" />


                
                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

            </form>
            @else
            <div class="alert alert-danger text-center">
                <div>😩</div>
                <div><h5>Diluar Waktu Absen</h5></div>
            </div>
            
            @endif
            
        </div>

    </x-form-card>



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
   

</x-guest-layout>