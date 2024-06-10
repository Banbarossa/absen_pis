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
            0 => 'Minggu',
            7 => 'Undefined',
        ];
        @endphp


        <x-header>
            <h4 class="page-title">Pengelolaan Roster Pembelajaran</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">Rombel: {{$nama_rombel}}</h4>
                    <div>
                        @if ($schedule && $roster->count() < 1)
                        <button wire:click='generateJadwal({{$schedule->id}})' type='button' class="btn btn-primary">Generate Jadwal</button>
                        @endif

                        <button class="btn btn-primary" data-toggle="modal" data-target="#crudModal">Tambah Jadwal</button>
                       
                    </div>
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Hari</th>
                                {{-- <th>jam_id</th> --}}
                                <th>Jam Ke</th>
                                <th>Mulai KBM</th>
                                <th>Akhir KBM</th>
                                <th>Nama</th>
                                <th>Mata Pelajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pageNumber = ($roster->currentPage() - 1) * $roster->perPage();
                            @endphp
                            
                            @forelse ($roster as $key => $item)
                            <tr>
                                <td scope="row">{{$pageNumber + $key + 1}}</td>
                                <td>{{ $hariMapping[$item->hari]}}</td>
                                {{-- <td>{{$item->jammengajar_id}}</td> --}}
                                <td>{{$item->jam_ke}}</td>
                                <td>{{$item->mulai_kbm}}</td>
                                <td>{{$item->akhir_kbm}}</td>
                                <td>{{$item->user_id ? $item->user->name :''}}</td>
                                <td>{{$item->mapel_id ? $item->mapel->mata_pelajaran:''}}</td>
                             
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#addGuru" wire:click='edit({{$item->id}})'>
                                                edit
                                            </button>
                                            <button class="dropdown-item" wire:confirm="Are you sure you want to delete this post?" wire:click='destroy({{$item->id}})'>Delete</button>

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
                    <div>{{$roster->links()}}</div>
                </div>

            </div>
        </div>


        {{-- modal --}}
         <x-crud-modal title="Tambah Data Roster">
            <table class="table">
                <thead>
                    <tr>
                        <td>Hari</td>
                        <td>Jam Ke</td>
                        <td>Mulai KBM</td>
                        <td>Akhir KBM</td>
                        <td>Jumlah Jam </td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jammengajarNotInRoster as $jamBaru)
                        <tr>
                            <td>{{$hariMapping[$jamBaru->hari]}}</td>
                            <td>{{$jamBaru->jam_ke}}</td>
                            <td>{{$jamBaru->mulai_kbm}}</td>
                            <td>{{$jamBaru->akhir_kbm}}</td>
                            <td>{{$jamBaru->jumlah_jam}}</td>
                            <td>
                                <button class="dropdown-item" wire:click='addJamToRoster({{$jamBaru->id}})'><i class="fa fa-plus-square"></i></button>
                            </td>
                        </tr>
                    
                    @empty
                    <tr>
                        <td colspan="6">Silahkan Menambahkan jam di pengaturan jam</td>
                    </tr>
                        
                    @endforelse
                </tbody>
            </table>
        </x-crud-modal>

        {{-- modal addGuru --}}
         <x-crud-modal title="Edit Roster" id="addGuru">
            <form action="" wire:submit='editRoster'>
                
                <table class="table mb-5">
                    <thead>
                        <tr>
                            <td>Hari</td>
                            <td>Jam Ke</td>
                            <td>Mulai KBM</td>
                            <td>Akhir KBM</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$hari ? $hariMapping[$hari] :''}}</td>
                            <td>{{$jam_ke}}</td>
                            <td>{{$mulai_kbm}}</td>
                            <td>{{$akhir_kbm}}</td>
                        </tr>
                    </tbody>
                </table>

             
                <div class="form-group">
                    <label for="user_id">Guru/Pengajar</label>
                    <select wire:model.live='user_id' class="select2 form-control custom-select select2-hidden-accessible @error('user_id') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Guru/Pengajar</option>
                        @foreach ($guru as $item)
                            <option value="{{$item->id}}" >{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mapel_id">Mata Pelajaran</label>
                    <select wire:model.live='mapel_id' class="select2 form-control custom-select select2-hidden-accessible @error('mapel_id') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Mata Pelajaran</option>
                        @foreach ($mapels as $mapel)
                            <option value="{{$mapel->id}}">{{$mapel->mata_pelajaran}}</option>
                        @endforeach
                    </select>
                    @error('mapel_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>


                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                
            </form>
        </x-crud-modal>

    </x-content-area>

    @push('script')
        <script>
            window.addEventListener('close-modal',event=>{
             $('#addGuru').modal('hide');
         })

        </script>
    @endpush


</div>




