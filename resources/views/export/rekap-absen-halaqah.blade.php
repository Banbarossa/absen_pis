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
                <td colspan="8"><strong>Rekap Kehadiran Musyrif Halaqah</strong></td>
            </tr>
            <tr>
                <td colspan="8">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="8">Didownload oleh : {{ Auth::user()->name }}</td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="8">Periode : {{ $periode }}</td>
            </tr>
        </thead>
        <tbody>
            <tr>
            </tr>
            <tr>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;"><strong>NO</strong>
                </td>
                <td align="start" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Nama</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Hadir (Jp)</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Izin Dinas (Jp)</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Izin Pribadi (JP)</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Sakit (Jp)</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Alpa (Jp)</strong></td>
            </tr>
            <?php $no = 0;?>
            @foreach($models as $item)
                <?php $no++;?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['nama'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['hadir'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['izin_dinas'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['izin_pribadi'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['sakit'] }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item['alpa'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
