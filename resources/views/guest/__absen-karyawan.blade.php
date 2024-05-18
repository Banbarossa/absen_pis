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
            @push('style')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
                <style>
                    .camera , .camera video{
                        display: inline-block;
                        /* border-radius: 15%; */
                        width: 100% !important;
                        margin: auto;
                        height: auto !important;
                    }
                    #map {
                         height: 250px; 
                    }
                </style>
            @endpush
            <div class="row">
                <div class="col">
                    <div id="my_camera" class="camera"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="results"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="map"></div>
                </div>
            </div>
            

            <form class="form-horizontal m-t-20" method="POST" action="{{route('absen-karyawan.store')}}">
            
                @csrf
                <div class="text-center form-group row m-t-20">
                    
                    <div class="col">
                        <input type="text" id="lokasi">
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-6">
                        <div id="results" class="text-center text-muted">Hasil Capture</div>
                    </div>
                  
                    <div class="mt-3 col-12">
                        <input type=button class="btn btn-sm btn-outline-success" value="Take Snapshot" onClick="take_snapshot()">
                    </div>
                   
                </div>

                <input type="number" id="jamkaryawan_id" name="jamkaryawan_id" value="">
                <input type="text" id="type" name="type" value="">
                <input type="hidden" id="latitudeInput" name="latitude">
                <input type="hidden" id="longitudeInput" name="longitude">
                <x-text-input label="Password Absen Anda" name="password_absen" type="text" />


                
                <div class="text-center form-group row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

            </form>
            
        </div>

    </x-form-card>



    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        Webcam.set({
            width: 320,
            height: 240,
            dest_width: 640,
            dest_height: 480,
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

        var lokasi =document.getElementById('lokasi');
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback,errorCallback)
            
        }else{
            alert("Browser Anda tidak mendukung geolokasi.");
        }

        function successCallback(position){
            lokasi.value=position.coords.latitude +','+ position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 200
            }).addTo(map);
        }

        
        function errorCallback(){
            console.error("Gagal mengambil lokasi:", error.message);
        }

    </script>
        
    @endpush
   

</x-guest-layout>