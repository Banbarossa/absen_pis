<div>
    <x-content-area>
     
        <x-header>
            <h4 class="page-title">Absen Luar Jadwal</h4>
        </x-header>


        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form action="" wire:submit.prevent='store'>
                            <div class="mr-2 form-group">
                                <label for="user_id">Nama Guru</label>
                                <select class="form-control @error('user_id')  is-invalid @enderror" wire:model='user_id' aria-label="Default select example">
                                    <option selected>Pilih Guru</option>
                                    @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="startDate">jam Ke</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" wire:model='jam_ke' aria-label="jam_ke">
                                    <option selected>Jam Ke</option>
                                    <option value="1">1-2</option>
                                    <option value="3">3-4</option>
                                    <option value="5">5-6</option>
                                    <option value="7">7-8</option>
                                </select>
                                @error('jam_ke')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" wire:model='tanggal'>
                                @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="mulai_kbm">Mulai KBM</label>
                                <input type="time" class="form-control" id="mulai_kbm" wire:model='mulai_kbm'>
                                @error('mulai_kbm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="akhir_kbm">Mulai KBM</label>
                                <input type="time" class="form-control" id="akhir_kbm" wire:model='akhir_kbm'>
                                @error('akhir_kbm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="rombel_id">Rombel</label>
                                <select class="form-control @error('rombel_id')  is-invalid @enderror" wire:model='rombel_id' aria-label="RombelId">
                                    <option selected>Nama Rombel</option>
                                    @foreach ($rombels as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_rombel }}</option>
                                    @endforeach
                                </select>
                                @error('rombel_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="mapel_id">Rombel</label>
                                <select class="form-control @error('mapel_id')  is-invalid @enderror" wire:model='mapel_id' aria-label="RombelId">
                                    <option selected>mata Pelajaran</option>
                                    @foreach ($mapels as $item)
                                    <option value="{{ $item->id }}">{{ $item->mata_pelajaran }}</option>
                                    @endforeach
                                </select>
                                @error('mapel_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mr-2 form-group">
                                <label for="jumlah_jam">Jumlah Jam</label>
                                <select class="form-control @error('jumlah_jam') is-invalid @enderror" wire:model='jumlah_jam' aria-label="jumlah_jam">
                                    <option value="2">2</option>
                                </select>
                                @error('jumlah_jam')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>


                            <div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </x-content-area>

</div>
