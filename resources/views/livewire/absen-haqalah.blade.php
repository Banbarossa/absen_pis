<div>
    <x-form-card>
        <x-slot name="logo">
            <h3 class="text-center mt-5 m-b-15">
                <a href="index.html" class="logo logo-admin"><img src="assets/images/logo.png" height="100" alt="logo"></a>
            </h3>
        </x-slot>

        <div class="p-3">

            <input type="hidden" id="latitudeInput" wire.model.live="latitude" placeholder="Latitude">
            <input type="hidden" id="longitudeInput" wire.model.live="longitude" placeholder="Longitude">

            @if (!$isInRadius)
            <div class="alert alert-danger" role="alert">
                <strong>Anda</strong> Berada berada diluar radius.
            </div>
            @endif


            <form class="form-horizontal m-t-20" wire:submit='absen'>
                <x-text-input-livewire type="password" name="password_absen" label="Password"></x-text-input-livewire>
                <div class="form-group text-center row m-t-20">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Absen Sekarang</button>
                    </div>
                </div>
            </form>
        </div>

    </x-form-card>

    @push('script')
    <script>
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
</div>
