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
            navigator.geolocation.getCurrentPosition(successCallback,errorCallback)
        }else{
            alert("Browser Anda tidak mendukung geolokasi.");
        }

        function successCallback(position){
            let latKantor = document.getElementById('latKantor').getAttribute('data-lokasi');
            let longKantor = document.getElementById('longKantor').getAttribute('data-lokasi');

            posisi =position.coords.latitude +','+ position.coords.longitude;
            lokasi.value = posisi;

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            var circle = L.circle([latKantor, longKantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {{ $bagianuser->radius }}
            }).addTo(map);

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