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
                <td colspan="8"><strong>Rekap Kehadiran Guru Mengajar</strong></td>
            </tr>
            <tr>
                <td colspan="8">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="8">Didownload oleh : {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td colspan="8">Jenjang : {{ strtoUpper($jenjang) }}</td>
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
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Jumlah Hari Hadir (H)</strong></td>
            </tr>
            <?php $no = 0; ?>
            @foreach($models as $item)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->user_name }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->jam_hadir ==0 ?'': $item->jam_hadir }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->jam_izindinas ==0 ?'': $item->jam_izindinas }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->jam_izinpribadi ==0 ?'': $item->jam_izinpribadi }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->jam_sakit ==0 ?'': $item->jam_sakit }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->jam_alpa ==0 ?'': $item->jam_alpa }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->jumlah_hari_hadir ==0 ?'': $item->jumlah_hari_hadir }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
