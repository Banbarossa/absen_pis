@push('script')
    
    <script>
        // Tampilkan Jam

        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90,
        });

        Webcam.attach( '#my_camera' );

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                var form =document.getElementById('form_store');
                $(".image-tag").val(data_uri);
                form.submit();
                // document.getElementById('result').innerHTML = '<img src="' + data_uri + '" class="rounded img-fluid"/>';
            } );
        }


        // Map
        var lokasi =document.getElementById('lokasi');

        if(navigator.geolocation){
            var options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 500
            };
            
            navigator.geolocation.getCurrentPosition(successCallback,errorCallback,options)
        }else{
            alert("Browser Anda tidak mendukung geolokasi.");
        }

        function successCallback(position){
            let latKantor = parseFloat(document.getElementById('latKantor').getAttribute('data-lokasi'));
            let longKantor = parseFloat(document.getElementById('longKantor').getAttribute('data-lokasi'));

            posisi =position.coords.latitude +','+ position.coords.longitude;
            lokasi.value = posisi;

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            const radius = {{ $radius }};

            var circle = L.circle([latKantor, longKantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius,
            }).addTo(map);


            const jarak = distance(latKantor, longKantor, position.coords.latitude, position.coords.longitude);
            if (jarak > radius){
                Swal.fire({
                    title: 'Warning!',
                    text: 'Browser mendeteksi anda Berada diluar Radius',
                    icon: 'warning',
                    toast:true,
                    timer:2500,
                    timerProgressBar:true,
                    confirmButtonText: 'close',
                })
            }


        }
        function errorCallback(){
            alert("Gagal mengambil lokasi ");
        }

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
                    timer:2500,
                    toast:true,
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
                    timer:2500,
                    toast:true,
                    confirmButtonText: 'close',
                })

                notifError.play();
            }
        });


        function distance(lat1, lon1, lat2, lon2) {
            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }

            const theta = lon1 - lon2;
            let miles = Math.sin(deg2rad(lat1)) * Math.sin(deg2rad(lat2)) + 
                        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                        Math.cos(deg2rad(theta));
            
            miles = Math.acos(miles);
            miles = rad2deg(miles);
            miles = miles * 60 * 1.1515;
            
            const feet = miles * 5280;
            const yards = feet / 3;
            const kilometers = miles * 1.609344;
            const meters = kilometers * 1000;
            
            return Math.round(meters);
        }

        function rad2deg(rad) {
            return rad * (180 / Math.PI);
        }

        
        
    </script>
    @endpush