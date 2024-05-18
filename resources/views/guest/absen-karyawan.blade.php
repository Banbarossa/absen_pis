<x-guest-layout>
    <x-form-card>
        <div class="px-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div id="success-message" data-message="{{ session('success') }}"></div>
            @endif

            @if (session('error'))
                <div id="error-message" data-message="{{ session('error') }}"></div>
            @endif

            
            @push('style')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
            <style>
                #map{
                    height: 200px;
                    overflow: hidden;
                }
                #results{
                    width: 100% !important;
                }
            </style>
            @endpush

            <audio id="notif-error">
                <source src="{{ asset('assets/voice/gagal.mp3') }}" type="audio/mpeg">
            </audio>
            <audio id="notif-success">
                <source src="{{ asset('assets/voice/berhasil.mp3') }}" type="audio/mpeg">
            </audio>


            <div class="mb-4 text-center">
                <h4>Absen Karyawan</h4>

                
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
            </div>
            
            {{-- @if ($jam_karyawan) --}}
                
            <form class="form-horizontal m-t-20" method="POST" action="{{ route('absen-karyawan.store') }}">
            
                @csrf
                <div class="text-center form-group row m-t-20">
                    {{-- form hiddent --}}
                    <div class="col-12">
                        <input type="text" name="jamkaryawan_id" value="{{ $jam_karyawan->id }}">
                        <input type="text" id="lokasi" name="lokasi">
                        <input type="text" id="absen_type" name="absen_type" value="{{ $absen_type }}">
                        <input type="text" id="bagianuser_id" name="bagianuser_id" value="{{ $bagianuser_id }}">
                    </div>

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

                <x-text-input label="Password Absen Anda" name="password_absen" type="text" />

                <div class="text-center form-group row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Absen Sekarang</button>
                    </div>
                </div>

                <div class="py-2 mt-6 d-block row">
                    <div class="col-12">
                        <div id="map" class="rounded"></div>
                    </div>
                </div>
                
            </form>
            
            {{-- @endif --}}
            
            {{-- @elseif ($absen && $absen->kehadiran == 'hadir')
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
            
            @endif --}}

            
        </div>

    </x-form-card>


    {{-- @if ($absen &&$absen->kehadiran !== "hadir") --}}
    @push('script')
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
            }
        </script>
        
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
                    document.getElementById('results').innerHTML = '<img src="' + data_uri + '" class="rounded img-fluid"/>';
                } );
            }

        </script>

        <script>
            var lokasi =document.getElementById('lokasi');

            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(successCallback,errorCallback)
            }else{
                alert("Browser Anda tidak mendukung geolokasi.");
            }

                function successCallback(position){
                    posisi =position.coords.latitude +','+ position.coords.longitude;
                    lokasi.value = posisi;

                    var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 14);
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(map);

                    var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

                    var circle = L.circle([5.463230, 95.386380], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);

                }
                function errorCallback(){
                    alert("Gagal mengambil lokasi ");
                }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                let successMessageElement = document.getElementById('success-message');
                let errorMessageElement = document.getElementById('error-message');

                if (successMessageElement) {
                    let message = successMessageElement.getAttribute('data-message');
                    let notifSuccess = document.getElementById('notif-success');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: message,
                        icon: 'success',
                        confirmButtonText: 'close',
                    })
                    notifSuccess.play();
                }

                if (errorMessageElement) {
                    let message = errorMessageElement.getAttribute('data-message');
                    let notifError = document.getElementById('notif-error');
                    Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'close',
                    })

                    notifError.play();
                }
            });
        </script>
    @endpush
    {{-- @endif --}}
   

</x-guest-layout>