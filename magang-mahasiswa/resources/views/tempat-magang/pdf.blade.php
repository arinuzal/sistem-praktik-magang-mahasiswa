<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PDF Mahasiswa Magang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Daftar Mahasiswa Magang - {{ $tempatMagang->nama_instansi }}</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Semester</th>
                <th>Status Magang</th>
                <th>Nilai Magang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mhs)
                <tr>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->semester }}</td>
                    <td>{{ $mhs->status_magang }}</td>
                    <td>{{ $mhs->nilai_magang ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
