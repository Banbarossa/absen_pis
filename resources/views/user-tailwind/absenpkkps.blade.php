<x-user-layout>
    <x-slot:title>
        Absen Mengajar
    </x-slot:title>

    @push('style')
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
    <style>
        #my_camera , video
        {
            width: 100% !important;
            border-radius: 20px;
            overflow: hidden;
            height: 100% !important;
        }
        #map{
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
        }
    </style>
    @endpush

    
    <div class="flex items-start justify-start w-full sm:max-w-md">
        <div class="w-full px-5 bg-white rounded-lg">
            <x-notif-absen></x-notif-absen>

            <div id="latKantor" data-lokasi="{{ $latitude }}"></div>
            <div id="longKantor" data-lokasi="{{ $longitude }}"></div>
            
            <div class="relative flex flex-col justify-center gap-3 mt-4 ">
                @if ($errors->any())
                    <x-alert-error :errors="$errors"></x-alert-error>
                @endif
        
                <div x-data="{camera:true}">
                    <div class="flex rounded-full ring-1 ring-red-300 ring-offset-2">
                        <button x-on:click='camera = true' 
                        type="button"
                        :class="{'bg-red-800 text-white' : camera, 'bg-white text-red-800':!camera}"
                        class="px-5 py-2.5 w-full text-sm font-medium  inline-flex items-center rounded-full text-center dark:bg-red-600 dark:hover:bg-red-700 justify-center gap-2">
                            <span>Kamera</span>
                        </button>
                        <button x-on:click='camera = false' 
                        type="button"
                        :class="{'bg-red-800 text-white' : !camera, 'bg-white text-red-800':camera}"
                        class="px-5 py-2.5 w-full text-sm font-medium  inline-flex items-center rounded-full text-center dark:bg-red-600 dark:hover:bg-red-700 justify-center gap-2">
                            <span>Maps</span>
                        </button>
                    </div>
                    <div class="relative my-4">
                        <div x-show="camera" class="w-full">
                            <div id="my_camera" class="overflow-hidden shadow-lg rounded-xl "></div>
                        </div>
                        <div x-show="!camera">
                            <div id="map" class="z-0 shadow-lg rounded-xl "></div>
                        </div>
        
                        <div class="absolute top-0 right-0 p-4 text-xs bg-white bg-opacity-50 rounded-bl-lg">
                            <dl>
                                <dt class="text-gray-500">Kelas</dt>
                                <dd class="font-semibold">{{ strtoupper($absen->rombel->nama_rombel) }}</dd>
                            </dl>
                            <dl>
                                <dt class="text-gray-500">Mapel</dt>
                                <dd class="font-semibold">{{ strtoupper($absen->mapel->mata_pelajaran) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

        
                <div class="w-full sm:max-w-md">
                    <form id="form_store" method="POST" action="{{ route('v2.absen-kbm-store',$absen->id) }}">
                        @csrf
                        <input type="hidden" id="lokasi" name="lokasi">
                        <input type="hidden" id="image-tag" name="image" class="image-tag">
                        <button onClick="take_snapshot()" type="button" class="inline-flex items-center justify-center w-full gap-2 px-5 py-4 mt-4 mb-8 font-medium text-center text-white bg-red-700 rounded-full hover:bg-red-800 ring-1 ring-offset-2 ring-red-600 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg class="w-6 h-6" stroke="currentColor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9"/>
                            </svg>
                            <span>Absen Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    

    @push('script')
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
        <script src="{{ asset('leaflet/leaflet.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
    @include('guest.tailwind.part-absen.script-absen')
    
        
</x-user-layout>