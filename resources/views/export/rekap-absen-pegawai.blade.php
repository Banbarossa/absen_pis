<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absen</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="8"><strong>Rekap Kehadiran Pegawai</strong></td>
            </tr>
            <tr>
                <td colspan="8">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="8">Didownload oleh : {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td colspan="8">Periode : {{ $periode }}</td>
            </tr>
        </thead>
        <tbody>
            <!-- siswa  -->
            <tr>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NO</strong>
                </td>
                <td align="start" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Nama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Masuk 1</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Terlambat Masuk 1</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Masuk 2</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Terlambat Masuk 2</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Pulang</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Hari Hadir</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Total terlambat</strong></td>
            </tr>
            <?php $no = 0; ?>
            @foreach($models as $item)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['user_name'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['jumlah_scan_masuk1'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['terlambat_masuk1']." Menit" }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['jumlah_scan_masuk2'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['terlambat_masuk2']." Menit" }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['jumlah_scan_pulang'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['total_hadir'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['terlambat_masuk1']+$item['terlambat_masuk2']." Menit" }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
