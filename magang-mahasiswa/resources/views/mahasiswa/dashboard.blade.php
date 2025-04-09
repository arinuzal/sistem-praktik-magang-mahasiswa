@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Dashboard Mahasiswa</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
   {{ session('success') }}
   </div>
@endif

@if ($errors->any())
 <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
     <ul class="list-disc list-inside">
       @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
       @endforeach
   </ul>
</div>
@endif

    {{-- Identitas Mahasiswa --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Identitas Mahasiswa</h2>
        <ul class="space-y-2 text-gray-800">
            <li><strong>Nama:</strong> {{ $mahasiswa->nama }}</li>
            <li><strong>NIM:</strong> {{ $mahasiswa->nim }}</li>
            <li><strong>Semester:</strong> {{ ucfirst($mahasiswa->semester) }}</li>
            <li><strong>Status Dokumen:</strong> {{ $mahasiswa->status_dokumen }}</li>
            <li><strong>Mata Kuliah:</strong>
                <ul class="list-disc list-inside ml-4">
                    @foreach (json_decode($mahasiswa->mata_kuliah) as $mk)
                        <li>{{ $mk }}</li>
                    @endforeach
                </ul>
            </li>
        </ul>

        {{-- KRS & Bukti Pembayaran --}}
        @if($mahasiswa->bukti_krs || $mahasiswa->bukti_pembayaran)
        <div class="mt-4">
            <h3 class="font-semibold text-gray-700 mb-2">Dokumen Tambahan:</h3>
            <ul class="space-y-1 text-sm">
                @if($mahasiswa->bukti_krs)
                    <li>
                        📄 <a href="{{ asset('storage/' . $mahasiswa->bukti_krs) }}" class="text-blue-600 underline" target="_blank">Lihat KRS</a>
                    </li>
                @endif
                @if($mahasiswa->bukti_pembayaran)
                    <li>
                        💳 <a href="{{ asset('storage/' . $mahasiswa->bukti_pembayaran) }}" class="text-blue-600 underline" target="_blank">Lihat Bukti Pembayaran</a>
                    </li>
                @endif
            </ul>
        </div>
        @endif
    </div>

    {{-- Informasi Magang --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Informasi Magang</h2>
        <ul class="space-y-2 text-gray-800">
            @if($mahasiswa->kelompok)
                <li><strong>Kelompok:</strong> {{ $mahasiswa->kelompok }}</li>
            @endif
            @if($mahasiswa->tempatMagang)
            <p><strong>Tempat Magang:</strong> {{ $mahasiswa->tempatMagang->nama_instansi }}</p>
            @endif
            <li><strong>Status Magang:</strong> {{ $mahasiswa->status_magang }}</li>
            @if($mahasiswa->nilai_magang)
                <li><strong>Nilai Magang:</strong> {{ $mahasiswa->nilai_magang }}</li>
            @endif
        </ul>
    </div>

    {{-- Ceklist atau Upload Berdasarkan Semester --}}
    @if($mahasiswa->semester === 'gasal')
    <div class="bg-blue-50 p-6 rounded-lg mb-6">
        <h2 class="text-lg font-semibold mb-4">Ceklist Semester Gasal</h2>
        <form action="{{ route('mahasiswa.updateCeklis') }}" method="POST">
            @csrf
            <label class="flex items-center mb-2">
                <input type="checkbox" name="penyuluhan" class="mr-2" {{ $mahasiswa->ceklis_penyuluhan ? 'checked' : '' }}>
                Sudah mengikuti penyuluhan
            </label>
            <label class="flex items-center mb-2">
                <input type="checkbox" name="artikel" class="mr-2" {{ $mahasiswa->ceklis_artikel ? 'checked' : '' }}>
                Sudah mengunggah artikel
            </label>
            <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </form>
    </div>
    @elseif($mahasiswa->semester === 'genap')
        <div class="bg-green-50 p-6 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-4">Upload Semester Genap</h2>
            <form action="{{ route('mahasiswa.upload.video') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-6">
                @csrf

                <div>
                    <label for="video_mediasi">Upload Video Mediasi</label>
                    <input type="file" name="video_mediasi" id="video_mediasi" accept="video/*" class="block w-full mt-1">
                </div>

                <div>
                    <label for="video_penyuluhan">Upload Video Penyuluhan</label>
                    <input type="file" name="video_penyuluhan" id="video_penyuluhan" accept="video/*" class="block w-full mt-1">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Upload Video
                </button>
            </form>
        </div>
    @endif

    {{-- Mahasiswa Luar Biasa --}}
    @if($mahasiswa->is_luar_biasa)
    <form action="{{ route('mahasiswa.uploadLinkArtikel') }}" method="POST">
        @csrf
        <label class="text-white" for="link_artikel">Link Artikel:</label>
        <input type="url" name="link_artikel" required class="w-full p-2 border rounded">
        <button type="submit" class="mt-3 mb-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Unggah Link
        </button>
    </form>
  @endif

    {{-- Sertifikat Otomatis Jika Lulus --}}
    @if($mahasiswa->nilai_magang && $mahasiswa->nilai_magang >= 70)
        <div class="bg-indigo-50 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-3 text-indigo-800">🎓 Sertifikat Kelulusan</h2>
            <p class="text-gray-700 mb-3">Selamat! Kamu telah dinyatakan <strong>lulus</strong> praktik magang.</p>
            <a href="{{ route('mahasiswa.cetak-sertifikat') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Download Sertifikat
            </a>
        </div>
    @endif
</div>
@endsection
