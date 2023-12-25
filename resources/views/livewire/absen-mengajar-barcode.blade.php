<div>
    <x-form-card>
        <x-slot name="logo">
            <h3 class="text-center mt-5 m-b-15">
                <a href="index.html" class="logo logo-admin"><img src="assets/images/logo.png" height="100" alt="logo"></a>
            </h3>
        </x-slot>

        <div class="p-3">
         
            

            @if (!$isInRadius)
            <div class="alert alert-danger mb-5" role="alert">
                <strong>Anda</strong> Berada berada diluar radius.
            </div>
            @endif
            @if ($absen_id)
            <div id="confirmation">
                <h5 class="text-center mb-3">Konfirmasi Absen</h5>
                <ul>
                    <li>Nama : {{$user_name}}</li>
                    <li>Rombel : {{$nama_rombel}}</li>
                    <li>Jam Ke : {{$jam_ke}}</li>
                    <li>Pelajaran : {{$mapel}}</li>
                </ul>
            </div>
            <div class="form-group text-center row m-t-20 mt-4">
                <div class="col-12">
                    <button class="btn btn-success btn-block waves-effect waves-light" wire:click='absensi' type="submit">Absen Sekarang</button>
                </div>
            </div>
            @endif
            
            {{$latitude}}||{{$longitude}}||{{$password_absen}}
            
            <div class="{{$absen_id ? 'd-none': ''}}">
                <form class="form-horizontal m-t-20" wire:submit='confirmation'>
                    <input type="text" id="" wire.model.live="test" placeholder="Latitude">
                    <input type="text" id="longitudeInput" wire.model="longitude" placeholder="Longitude">
                    <x-text-input-livewire type="password" name="password_absen" label="Password"></x-text-input-livewire>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- coba kamera --}}
            <form method="POST" action="{{ route('webcam.capture') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div id="my_camera"></div>
                        <br/>
                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-md-6">
                        <div id="results">Your captured image will appear here...</div>
                    </div>
                    <div class="col-md-12 text-center">
                        <br/>
                        <button class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
            
        </div>

    </x-form-card>

    @push('script')
    <script>
         Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    
    Webcam.attach( '#my_camera' );
    
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
    </script>

    {{-- <script>
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
    </script> --}}



    
        
    @endpush
</div>
