<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{config('app.name')}}</title>
    <meta content="Guest" name="Absensi Digital Pesantren Imam Syafii" />
 

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <style>
        #my_camera , video{
            width: 100% !important;
            height: 160px !important;
            border-radius: 15px;
        }
        #map {
            height: 250px; 
        }
    </style>
    
    @include('layouts.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body>
    <div class="justify-center min-vh-100 d-flex justify-content-center">
        <div class="col-12 col-lg-8" style="padding-top:1rem; padding-bottom:4rem">
            <x-form-card>
                <h3 class="text-center text-secondary">Absen Karyawan</h3>
                {{-- time --}}
                <div class="pt-2 d-flex justify-content-center fw-bold bg-primary align-items-center text-light">
                    <div class="flex kotak">
                        <p class="h3" id="jam"></p>
                    </div>
                    <div class="kotak">
                        <p class="h3" id="menit"></p>
                    </div>
                    <div class="kotak">
                        <p class="h3" id="detik"></p>
                    </div>
                </div>

                {{-- gambar --}}
                <div class="mt-3 row">
                    <div class="col-12">
                        <div id="my_camera"></div>
                    </div>
                    <div class="col-12">
                        <div id="map"></div>
                    </div>
                    <div class="col-12">
                        <div id="results" class="text-center text-muted">Hasil Capture</div>
                    </div>
                </div>
                <div class="mt-3 col-12">
                    <input type=button class="d-block btn btn-sm btn-outline-success" value="Take Snapshot" onClick="take_snapshot()">
                </div>

                <input type="text" id="lokasi">


            </x-form-card>
        </div>
    </div>

    @include('layouts.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        window.setTimeout("waktu()",1000)
        function waktu(){
            var waktu = new Date();
            setTimeout("waktu()",1000);
            document.getElementById('jam').innerHTML=waktu.getHours()+' : ';
            document.getElementById('menit').innerHTML=waktu.getMinutes()+' : ';
            document.getElementById('detik').innerHTML=waktu.getSeconds();
        };


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
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '" style="height: 160px; width: 100%; object-fit:cover;"/>';
            } );
        }


        var lokasi =document.getElementById('lokasi');

        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback,errorCallback)
        }else{
            alert("Browser Anda tidak mendukung geolokasi.");
        }

        function successCallback(position){
            posisi =position.coords.latitude +','+ position.coords.longitude;
            lokasi.value = posisi;

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
            alert("Gagal mengambil lokasi ");
        }

        
    </script>
    
</body>
</html>