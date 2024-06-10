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
                <td colspan="6"><strong>Rekap Kehadiran Santri/Siswa</strong></td>
            </tr>
            <tr>
                <td colspan="6">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="6">Didownload oleh : {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td colspan="6">Nama Siswa : {{ $studentName }}</td>
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
                    <strong>Tanggal</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Nama Guru</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Pelajaran</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Jam Ke</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>Status Kehadiran</strong></td>
            </tr>
            <?php $no = 0; ?>
            @foreach($models as $item)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absensekolah ?  $item->absensekolah->user->name :'undefined' }}</td>
                    <td align="center" style="border: 1px solid #000000;"> {{ $item->absensekolah->mapel ?  ucFirst($item->absensekolah->mapel->mata_pelajaran) :'undefined' }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->absensekolah ? $item->absensekolah->jam_ke :''}}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ ucWords($item->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
