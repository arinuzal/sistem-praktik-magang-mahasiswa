@component('mail::message')
# Penilaian Mahasiswa

Nama Mahasiswa: **{{ $penilaian->mahasiswa->nama ?? '-' }}**
Nilai Magang: **{{ $penilaian->nilai_magang }}**
Nilai Video Mediasi: **{{ $penilaian->nilai_video_mediasi }}**
Nilai Penyuluhan: **{{ $penilaian->nilai_penyuluhan }}**
**Nilai Mata Kuliah Praktik: {{ $penilaian->nilai_akhir ?? 'Belum dihitung' }}**


Terima kasih,<br>
Sistem Praktik Magang Mahasiswa
@endcomponent
