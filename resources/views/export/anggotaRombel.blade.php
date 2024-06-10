<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9"><strong>Daftar Siswa Aktif</strong></td>
            </tr>
            <tr>
                <td colspan="9">Waktu download : {{ $time_download }}</td>
            </tr>
            <tr>
                <td colspan="9">Didownload oleh : {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <td colspan="9">Kelas : {{ $rombelName }}</td>
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
                    <strong>NISN</strong></td>
                <td align="center" style="border: 1px solid #000000; background-color: #d9ecd0;">
                    <strong>NIS</strong></td>
            </tr>
            <?php $no = 0; ?>
            @foreach($models as $item)
                <?php $no++; ?>
                <tr>
                    <td align="center" style="border: 1px solid #000000;">{{ $no }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->student->name }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->student->nisn }}</td>
                    <td align="center" style="border: 1px solid #000000;">{{ $item->student->nis }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
