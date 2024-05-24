<div>
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="flex-row d-flex">
                        <div class="col-3 align-self-center">
                            @if ($absenmasuk2)
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
                                <h6 class="mt-0 round-inner">MASUK 2</h6>
                                @if ($absenmasuk2)
                                <p class="mb-0 text-muted">{{ $absenmasuk2->jam }}</p>  
                                @else                                                               
                                <p class="mb-0 text-muted">Anda Belum Absen</p>
                                <button onclick="showAlert('masuk_2')">Absen Dinas Luar</button>
                                {{-- <a href="" onclick="showAlert()"><small>Absen Dinas Luar</small></a>                                                                 --}}
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
        function showAlert(type){

            alert(type);
            
            // Swal.fire({
            //     title: "Do you want to save the changes?",
            //     showDenyButton: true,
            //     showCancelButton: true,
            //     confirmButtonText: "Save",
            //     denyButtonText: `Don't save`
            //     }).then((result) => {
            //     /* Read more about isConfirmed, isDenied below */
            //     if (result.isConfirmed) {
            //         Swal.fire("Saved!", "", "success");
            //     } else if (result.isDenied) {
            //         Swal.fire("Changes are not saved", "", "info");
            //     }
            // });
        }
    </script>
        
    @endpush
</div>
