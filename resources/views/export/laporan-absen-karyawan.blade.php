<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9"><strong>Riwayat Absen Karyawan</strong></td>
            </tr>
            <tr>
                <td colspan="9">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="9">Didownload oleh : {{ Auth::user()->name }}</td>
            </tr>
        </thead>
        <tbody>
            <!-- siswa  -->
            <tr>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NO</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Nama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Tanggal</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Bagian</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Jam Masuk 1</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Scan masuk 1</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Terlambat Masuk 1</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Jam Masuk 2</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Scan masuk 2</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Terlambat Masuk 2</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Jam Pulang</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Scan Pulang</strong>
                </td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>Pulang Cepat</strong>
                </td>
            </tr>
            <?php $no = 0; ?>
            @foreach($models as $item)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->user ? $item->user->name:'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->tanggal }}</td>
                    <td style="border: 1px solid #000000;">{{ $item->bagianuser ? $item->bagianuser->name:'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->bagianuser->jamkaryawans ? $item->bagianuser->jamkaryawans()->latest()->first()->jam_masuk_1 :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absenkaryawandetails->where('type','masuk_1')->first() ? $item->absenkaryawandetails->where('type','masuk_1')->first()->jam :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absenkaryawandetails->where('type','masuk_1')->first() ? $item->absenkaryawandetails->where('type','masuk_1')->first()->selisih_waktu :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->bagianuser->jamkaryawans ? $item->bagianuser->jamkaryawans()->latest()->first()->jam_masuk_2 :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absenkaryawandetails->where('type','masuk_2')->first() ? $item->absenkaryawandetails->where('type','masuk_2')->first()->jam :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absenkaryawandetails->where('type','masuk_2')->first() ? $item->absenkaryawandetails->where('type','masuk_2')->first()->selisih_waktu :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->bagianuser->jamkaryawans ? $item->bagianuser->jamkaryawans()->latest()->first()->pulang :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absenkaryawandetails->where('type','pulang')->first() ? $item->absenkaryawandetails->where('type','pulang')->first()->jam :'' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absenkaryawandetails->where('type','pulang')->first() ? $item->absenkaryawandetails->where('type','pulang')->first()->selisih_waktu :'' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
