<div>
    <x-content-area>

        @php
        $hariMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        @endphp

        <x-header>
            <h4 class="page-title">Schedule</h4>
        </x-header>


        {{-- Jadwal Jam --}}
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="mt-0 header-title">Nama Jadwal</h4>
                        </div>
                        <div class="form-group text-center row m-t-20">
                            @foreach ($model as $item)
                            <div class="col-12 mt-2 d-flex">
                                <button class="btn btn-{{$schedule_id == $item->id ? 'primary':'outline-secondary'}} btn-block waves-effect waves-light" wire:click='getScheduleId({{$item->id}})' data-toggle="pill" href="#v-pills-{{$item->id}}" role="tab" aria-controls="v-pills-{{$item->id}}" aria-selected="false">{{ucFirst($item->name)}}</button>
                                <button class="btn btn-sm text-danger" wire:confirm='yakin untuk menghapus Jadwal?, Pastikan jadwal ini tidak digunakn di rombel!' wire:click='nonaktifkanSchedule({{$item->id}})'><i class="fa fa-trash-o"></i></button>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-body">
                        <div>
                            <form action="" wire:submit='addJadwal'>
                                <x-text-input-livewire type="text" name="new_schedule" label="Tambah Jadwal baru"></x-text-input-livewire>
                                <div class="form-group text-center row m-t-20">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light" >Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            


            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4 class="mt-0 header-title">Nama Jadwal</h4>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crudModal">
                                Tambah Jam Mengajar
                            </button>
                            
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach ($model as $item)
                            <div class="tab-pane fade {{$schedule_id == $item->id ? 'active show' :''}}" id="v-pills-{{$item->id}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                {{-- tehapus --}}
                                
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    @foreach ($hariMapping as $key=> $item)
                                    <li class="nav-item">
                                        <a class="nav-link {{$hari == $key ? 'active' :''}}" wire:click='gantiHari({{$key}})' data-toggle="tab" href="#home" role="tab" aria-selected="true">{{$item}}</a>
                                    </li>
                                    @endforeach
                                    
                                </ul>
                
                                <!-- Table Content -->
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="home" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered table-sortable">
                                                <thead>
                                                    <tr>
                                                        <th class="sort">hari</th>
                                                        <th class="sort @if($sortColumn == 'jam_ke') {{$sortDirection}} @endif" wire:click="sort('jam_ke')">Jam Ke</th>
                                                        <th class="sort @if($sortColumn == 'mulai_kbm') {{$sortDirection}} @endif" wire:click="sort('mulai_kbm')">Mulai Kbm</th>
                                                        <th class="sort @if($sortColumn == 'akhir_kbm') {{$sortDirection}} @endif" wire:click="sort('akhir_kbm')">Akhir Kbm</th>
                                                        <th class="sort @if($sortColumn == 'mulai_absen') {{$sortDirection}} @endif" wire:click="sort('mulai_absen')">Mulai Absen</th>
                                                        <th class="sort @if($sortColumn == 'akhir_absen') {{$sortDirection}} @endif" wire:click="sort('akhir_absen')">Akhir Absen</th>
                                                        <th class="sort @if($sortColumn == 'jumlah_jam') {{$sortDirection}} @endif" wire:click="sort('jumlah_jam')">Jumlah Jam</th>
                                                        <th style="width: 110px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  
                                                    @forelse ($jamMengajar as $key => $item)
                                                    <tr>
                                                        <td>
                                                           
                                                            {{$hariMapping[$item->hari]}}
                                                        </td>
                                                        <td>{{$item->jam_ke}}</td>
                                                        <td>{{$item->mulai_kbm}}</td>
                                                        <td>{{$item->akhir_kbm}}</td>
                                                        <td>{{$item->mulai_absen}}</td>
                                                        <td>{{$item->akhir_absen}}</td>
                                                        <td>{{$item->jumlah_jam}}</td>
                        
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#crudModal" wire:click='edit({{$item->id}})'>
                                                                        Edit
                                                                    </button>
                                                                    <button class="dropdown-item" wire:confirm="Are you sure you want to delete this post?" wire:click='destroy({{$item->id}})'>Hapus</button>
                        
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <th colspan="8">🙌 No Data Found</th>
                                                    </tr>
                                                        
                                                    @endforelse
                            
                                                </tbody>
                                            </table>
                    
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>


        {{-- Modal create Update --}}

        <x-crud-modal title="{{$jam_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($jam_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif

            <x-text-input-livewire type="text" name="jam_ke" label="Jam Ke"></x-text-input-livewire>
            <x-text-input-livewire type="time" name="mulai_kbm" label="Mulai KBM"></x-text-input-livewire>
            <x-text-input-livewire type="time" name="akhir_kbm" label="Akhir KBM"></x-text-input-livewire>
            <x-text-input-livewire type="number" name="jumlah_jam" label="Jumlah Jam"></x-text-input-livewire>

                
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>           
            
        </x-crud-modal>


    </x-content-area>
</div>