<div>


<table class="table table-hover">
    <thead>
        <tr>
            <th class="border-top-0" style="width:60px;">Tanggal</th>
            <th class="border-top-0" style="width:60px;">Foto</th>
            <th class="border-top-0">Absen</th>
            <th class="border-top-0">Jam Absen</th>
            <th class="border-top-0">Terlambat</th>
            <th class="border-top-0">Lokasi</th>                                    
        </tr>
    </thead>
    <tbody>
        @forelse ($models as $item)
            <tr>
                <th colspan="6">{{ \Carbon\Carbon::parse($item->created_at)->format('l, d M Y') }}</th>
            </tr>
            @foreach ($item->absenkaryawandetails as $item)
            <tr>
                <td></td>
                <td>
                    @if ($item->image)
                    <img class="rounded-circle" src="{{asset('storage/public/images/karyawan/'. $item->image)}}" alt="Absen" width="40"> 
                    @endif
                </td>
                <td>{{ ucWords(str_replace('_',' ',$item->type)) }}</td>
                <td>{{ $item->jam }}</td>
                <td>{{ $item->terlambat > 0 ? $item->terlambat. ' Menit':'' }}</td>
                <td><a href="https://www.google.com/maps?q={{ $item->lokasi }}" target="blank">Lihat Lokasi</a></td>
            </tr>
            @endforeach
            
        @empty
            <tr>
                <td>Tidak ada data yang ditemukan</td>
            </tr>
        @endforelse
    </tbody>

</div>
