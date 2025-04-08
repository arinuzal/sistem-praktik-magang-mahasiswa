<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Mahasiswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Data Mahasiswa</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Semester</th>
                <th>Status Dokumen</th>
                <th>Status Magang</th>
                <th>Tempat Magang</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswas as $mhs)
                <tr>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->semester }}</td>
                    <td>{{ $mhs->status_dokumen }}</td>
                    <td>{{ $mhs->status_magang }}</td>
                    <td>{{ $mhs->tempatMagang->nama_instansi ?? '-' }}</td>
                    <td>{{ $mhs->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
