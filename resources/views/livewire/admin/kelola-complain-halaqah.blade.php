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
            <h4 class="page-title">Kelola Complain Absen</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title">List Jadwal Halaqah</h4>
                    <div>
                        @if (!empty($dataToChange))
                        <div class="dropdown d-inline">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <button type="button" class="dropdown-item" wire:confirm='Apakah Yakin menerima Complain' wire:click='terimaBanyak'>
                                    Terima terpilih
                                </button>
                                <button class="dropdown-item" wire:confirm="Apakah yakin untuk menolak complain" wire:click='tolakBanyak' >Tolak terpilih</button>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <x-table-header/>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-sortable">
                        <thead>
                            <tr>
                                <th class="ps-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" wire:click='selectAll' wire:model='selectSemua'  class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                </th>
                                <th>No</th>
                                <th class="sort @if($sortColumn == 'name') {{$sortDirection}} @endif" wire:click="sort('name')">Nama</th>
                                <th class="sort @if($sortColumn == 'tanggal') {{$sortDirection}} @endif" wire:click="sort('tanggal')">Tanggal</th>
                                <th>Ubah Ke</th>
                                <th>Alasan Complain</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pageNumber = ($model->currentPage() - 1) * $model->perPage();
                            @endphp
                            
                            @forelse ($model as $key => $item)
                            <tr>
                                <td>
                                    @if (is_null($item->status))
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" wire:model.live='dataToChange' value='{{$item->id}}' class="custom-control-input" id="customCheck{{$item->id}}">
                                        <label class="custom-control-label" for="customCheck{{$item->id}}"></label>
                                    </div>
                                    @endif
                                    
                                </td>
                                <td scope="row">{{$pageNumber + $key + 1}}</td>
                                <td>{{ucFirst($item->absenhalaqah->user?$item->absenhalaqah->user->name:'')}}</td>
                                <td>
                                    <p>{{ucFirst($item->absenhalaqah? $item->absenhalaqah->tanggal:'')}}</p>
                                    <small>{{ $item->absenhalaqah && $item->absenhalaqah->jadwal_halaqah ? $item->absenhalaqah->jadwal_halaqah->nama_sesi : '' }}</small>
                                </td>
                                <td>{{ucFirst($item->change_to)}}</td>
                                <td>{{$item->reason}}</td>

                                <td>
                                    @if ($item->status === null)
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <button type="button" class="dropdown-item" wire:confirm='Apakah Yakin menerima Complain' wire:click='terimaComplain({{$item->id}})'>
                                                Terima
                                            </button>
                                            <button class="dropdown-item" wire:confirm="Apakah yakin untuk menolak complain" wire:click='tolakComplain({{$item->id}})'>Tolak</button>

                                        </div>
                                    </div>
                                    @else
                                    Sudah Diproses
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="7">🙌 No Data Found</th>
                            </tr>
                                
                            @endforelse
    
    
                        </tbody>
                    </table>
                </div>
               

                <div>
                    {{$model->links()}}
                </div>

            </div>
        </div>


         {{-- Modal create Update --}}

        {{-- <x-crud-modal title="{{$jadwal_halaqah_id ? 'Edit Data' :' Tambah Data'}}">
            @if ($jadwal_halaqah_id)
            <form wire:submit='editData'>
            @else
            <form wire:submit='create'>
            @endif
            <div>
                <div class="form-group">
                    <label for="hari">Pilih Hari</label>
                    <select wire:model='hari' class="select2 form-control mb-3 custom-select select2-hidden-accessible @error('hari') is-invalid @enderror"  tabindex="-1" aria-hidden="true">
                        <option>Pilih Hari</option>
                        @foreach ($hariMapping as $key => $item)
                            <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                    @error('hari')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <x-text-input-livewire type="text" name="nama_sesi" label="Nama Sesi"></x-text-input-livewire>
                <x-text-input-livewire type="time" name="mulai_absen" label="Mulai Absen"></x-text-input-livewire>
                <x-text-input-livewire type="time" name="akhir_absen" label="Akhir Absen"></x-text-input-livewire>
                <x-text-input-livewire type="number" name="insentif" label="Besaran Insentif"></x-text-input-livewire>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" wire:click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>           
            
        </x-crud-modal> --}}





    </x-content-area>
</div>