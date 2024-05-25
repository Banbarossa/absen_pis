<div>
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="flex-row d-flex">
                        <div class="col-3 align-self-center">
                            @if ($absenpulang)
                            <div>
                                <img src="{{asset('storage/public/images/karyawan/'. $absenmasuk1->image)}}" alt="Image" class="thumbnail rounded-circle">
                            </div>
                            @else
                            <div class="round">
                                <i class="mdi mdi-webcam"></i>
                            </div>
                            @endif
                        </div>
                        <div class="text-center col-9 align-self-center">
                            <div class="m-l-10">
                                <h6 class="mt-0 round-inner">{{ __('PULANG') }}</h6>
                                @if ($absenpulang)
                                <p class="mb-0 text-muted">{{ $absenpulang->jam }}</p>  
                                @else                                                               
                                <p class="mb-0 text-muted">Anda Belum Absen</p>
                                <button onclick="warning('masuk_2')" class="btn btn-sm btn-outline-warning">Absen Dinas Luar</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="flex-row d-flex">
                        <div class="col-3 align-self-center">
                            <div class="round">
                                <i class="mdi mdi-account-multiple-plus"></i>
                            </div>
                        </div>
                        <div class="text-center col-6 align-self-center">
                            <div class="m-l-10 ">
                                <h5 class="mt-0 round-inner">562</h5>
                                <p class="mb-0 text-muted">New Users</p>
                            </div>
                        </div>
                        <div class="col-3 align-self-end align-self-center">
                            <h6 class="float-right m-0 text-center text-success"> <i class="mdi mdi-arrow-up"></i> <span>8.68%</span></h6>
                        </div>                                                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="flex-row d-flex">
                        <div class="col-3 align-self-center">
                            <div class="round ">
                                <i class="mdi mdi-basket"></i>
                            </div>
                        </div>
                        <div class="text-center col-6 align-self-center">
                            <div class="m-l-10 ">
                                <h5 class="mt-0 round-inner">7514</h5>
                                <p class="mb-0 text-muted">New Orders</p>
                            </div>
                        </div>
                        <div class="col-3 align-self-end align-self-center">
                            <h6 class="float-right m-0 text-center text-danger"> <i class="mdi mdi-arrow-down"></i> <span>2.35%</span></h6>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="flex-row d-flex">
                        <div class="col-3 align-self-center">
                            <div class="round">
                                <i class="mdi mdi-rocket"></i>
                            </div>
                        </div>
                        <div class="text-center col-6 align-self-center">
                            <div class="m-l-10">
                                <h5 class="mt-0 round-inner">$32874</h5>
                                <p class="mb-0 text-muted">Total Sales</p>
                            </div>
                        </div>
                        <div class="col-3 align-self-end align-self-center">
                            <h6 class="float-right m-0 text-center text-success"> <i class="mdi mdi-arrow-up"></i> <span>2.35%</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>

    @push('script')
    <script>
        function warning(type){
            Swal.fire({
                title: "Absen Dinas Luar",
                text: "Absen dengan metode ini tidak masuk langsung ke data asben, sebelum di Approve oleh kepala bidang",
                showCancelButton: true,
                confirmButtonText: "Lanjut",
                }).then((result) => {
                if (result.isConfirmed) {
                    const route = "{{ route('user.absen.dinasluar', ':type') }}".replace(':type', type);
                    window.location.href = route;
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    </script>
        
    @endpush
</div>
