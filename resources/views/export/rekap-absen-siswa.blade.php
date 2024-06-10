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
                <td colspan="7"><strong>Rekap Kehadiran Santri/Siswa</strong></td>
            </tr>
            <tr>
                <td colspan="7">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="7">Didownload oleh : {{ Auth::user()->name }}</td>
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
                    <strong>Rombel</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Nama Siswa</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Hadir</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Izin</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Sakit</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Alpa</strong></td>
            </tr>
            <?php $no = 0; ?>
            @foreach($models as $item)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->nama_rombel }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->name }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->total_jam_h .' Jp' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->total_jam_i .' Jp' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->total_jam_s .' Jp' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->total_jam_a .' Jp' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
