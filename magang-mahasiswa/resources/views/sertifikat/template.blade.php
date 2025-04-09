<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Magang</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 150px; }
        h1 { font-size: 32px; }
        p { font-size: 18px; }
    </style>
</head>
<body>
    <h1>SERTIFIKAT MAGANG</h1>
    <p>Diberikan kepada:</p>
    <h2>{{ $mahasiswa->nama }}</h2>
    <p>NIM: {{ $mahasiswa->nim }}</p>
    <p>Atas partisipasinya dalam kegiatan magang dengan nilai: <strong>{{ $mahasiswa->nilai_magang }}</strong></p>
    <p>{{ date('d M Y') }}</p>
</body>
</html>
