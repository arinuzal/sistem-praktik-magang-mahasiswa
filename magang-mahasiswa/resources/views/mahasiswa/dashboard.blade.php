<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Mahasiswa - Sistem Praktik Magang">
    <title>Dashboard Mahasiswa - Sistem Praktik Magang</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            border-radius: 0.375rem;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">Dashboard Mahasiswa</h1>
                    <p class="text-blue-100 mt-1">Selamat datang, {{ $mahasiswa->nama }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-white hover:text-blue-200 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Notifikasi -->
        @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                <div>
                    <h4 class="font-bold">Terjadi Kesalahan!</h4>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Identitas Mahasiswa -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-id-card mr-3 text-blue-600"></i>
                        Identitas Mahasiswa
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium text-gray-800">{{ $mahasiswa->nama }}</p>
                        </div>
                        @if($mahasiswa->is_luar_biasa === 1)
                        <div>
                            <p class="text-sm text-gray-500">Mahasiswa</p>
                            <p class="font-medium text-gray-800">Luar Biasa</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500">NIM</p>
                            <p class="font-medium text-gray-800">{{ $mahasiswa->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Semester</p>
                            <p class="font-medium text-gray-800">{{ ucfirst($mahasiswa->semester) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Dokumen</p>
                            <span class="font-medium
                                @if($mahasiswa->status_dokumen == 'disetujui') text-green-600
                                @elseif($mahasiswa->status_dokumen == 'ditolak') text-red-600
                                @else text-yellow-600 @endif">
                                {{ $mahasiswa->status_dokumen }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Mata Kuliah</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @forelse($mahasiswa->mata_kuliah_formatted as $mk)
                                <span class="bg-gray-100 text-gray-800 rounded-full px-3 py-1 text-sm">
                                    {{ $mk['nama'] ?? 'Mata Kuliah' }}
                                    @if(!empty($mk['kelas']))
                                        - Kelas {{ $mk['kelas'] }}
                                    @endif
                                </span>
                            @empty
                                <span class="text-gray-500 italic">Belum ada mata kuliah terdaftar</span>
                            @endforelse
                        </div>
                    </div>

                    @if($mahasiswa->bukti_krs || $mahasiswa->bukti_pembayaran)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Dokumen Mahasiswa</h3>
                        <div class="space-y-3">
                            @if($mahasiswa->bukti_krs)
                            <a href="{{ asset('storage/' . $mahasiswa->bukti_krs) }}" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800 transition">
                                <i class="far fa-file-pdf mr-2 text-lg"></i>
                                <span>Lihat KRS</span>
                                <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                            </a>
                            @endif
                            @if($mahasiswa->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $mahasiswa->bukti_pembayaran) }}" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800 transition">
                                <i class="far fa-file-pdf mr-2 text-lg"></i>
                                <span>Lihat Bukti Pembayaran</span>
                                <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Magang -->
            @if(!$mahasiswa->is_luar_biasa)
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-briefcase mr-3 text-blue-600"></i>
                        Informasi Magang
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if($mahasiswa->kelompok)
                        <div>
                            <p class="text-sm text-gray-500">Kelompok</p>
                            <p class="font-medium text-gray-800">{{ $mahasiswa->kelompok }}</p>
                        </div>
                        @endif

                        @if($mahasiswa->tempatMagang)
                        <div>
                            <p class="text-sm text-gray-500">Tempat Magang</p>
                            <p class="font-medium text-gray-800">{{ $mahasiswa->tempatMagang->nama_instansi }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm text-gray-500">Status Magang</p>
                            <span class="font-medium
                                @if($mahasiswa->status_magang == 'aktif') text-green-600
                                @elseif($mahasiswa->status_magang == 'selesai') text-blue-600
                                @else text-gray-600 @endif">
                                {{ $mahasiswa->status_magang }}
                            </span>
                        </div>

                        @if($mahasiswa->nilai_magang)
                        <div>
                            <p class="text-sm text-gray-500">Nilai Magang</p>
                            <div class="flex items-center">
                                <span class="text-2xl font-bold
                                    @if($mahasiswa->nilai_magang >= 85) text-green-600
                                    @elseif($mahasiswa->nilai_magang >= 70) text-blue-600
                                    @else text-yellow-600 @endif">
                                    {{ $mahasiswa->nilai_magang }}
                                </span>
                                @if($mahasiswa->nilai_magang >= 70)
                                <span class="ml-2 badge bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Lulus
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Semester Gasal Section -->
            @if($mahasiswa->semester === 'gasal')
            <div class="lg:col-span-3 bg-blue-50 rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-blue-100 to-blue-200 px-6 py-4 border-b border-blue-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-tasks mr-3 text-blue-600"></i>
                        Checklist Semester Gasal
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('mahasiswa.updateCeklis') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <label class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="penyuluhan" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" {{ $mahasiswa->ceklis_penyuluhan ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-800">Penyuluhan</p>
                                    <p class="text-sm text-gray-500">Sudah mengikuti sesi penyuluhan magang</p>
                                </div>
                            </label>

                            <label class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="artikel" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" {{ $mahasiswa->ceklis_artikel ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-800">Artikel</p>
                                    <p class="text-sm text-gray-500">Sudah mengunggah artikel magang</p>
                                </div>
                            </label>
                        </div>
                        <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-sm transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Checklist
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Semester Genap Section -->
            @if($mahasiswa->semester === 'genap')
            <div class="lg:col-span-3 bg-green-50 rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-green-100 to-green-200 px-6 py-4 border-b border-green-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-video mr-3 text-green-600"></i>
                        Upload Video Semester Genap
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('mahasiswa.upload.video') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="video_mediasi" class="block text-sm font-medium text-gray-700 mb-1">Video Mediasi</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="file" name="video_mediasi" id="video_mediasi" accept="video/*" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: MP4, maksimal 50MB</p>
                            </div>

                            <div>
                                <label for="video_penyuluhan" class="block text-sm font-medium text-gray-700 mb-1">Video Penyuluhan</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="file" name="video_penyuluhan" id="video_penyuluhan" accept="video/*" class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: MP4, maksimal 50MB</p>
                            </div>
                        </div>
                        <button type="submit" class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-sm transition flex items-center">
                            <i class="fas fa-upload mr-2"></i> Upload Video
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Mahasiswa Luar Biasa -->
            @if($mahasiswa->is_luar_biasa)
            <div class="lg:col-span-3 bg-purple-50 rounded-xl shadow-md overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-purple-100 to-purple-200 px-6 py-4 border-b border-purple-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-star mr-3 text-purple-600"></i>
                        Unggah Artikel (Mahasiswa Luar Biasa)
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('mahasiswa.uploadLinkArtikel') }}" method="POST">
                        @csrf
                        <div>
                            <label for="link_artikel" class="block text-sm font-medium text-gray-700 mb-1">Link Artikel</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    <i class="fas fa-link"></i>
                                </span>
                                <input type="url" name="link_artikel" id="link_artikel" required class="focus:ring-purple-500 focus:border-purple-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="https://example.com/artikel-saya">
                            </div>
                        </div>
                        <button type="submit" class="mt-6 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg shadow-sm transition flex items-center">
                            <i class="fas fa-share-square mr-2"></i> Unggah Link
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Sertifikat Kelulusan -->
            @if($mahasiswa->nilai_magang && $mahasiswa->nilai_magang >= 70)
            <div class="lg:col-span-3 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl shadow-md overflow-hidden card-hover">
                <div class="px-6 py-4 border-b border-indigo-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-award mr-3 text-indigo-600"></i>
                        Sertifikat Kelulusan
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="mb-4 md:mb-0">
                            <p class="text-lg text-gray-800 mb-2">Selamat! Anda telah menyelesaikan praktik magang dengan nilai {{ $mahasiswa->nilai_magang }}.</p>
                            <p class="text-gray-600">Silahkan unduh sertifikat kelulusan Anda.</p>
                        </div>
                        <a href="{{ route('mahasiswa.cetak-sertifikat') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg shadow-sm transition flex items-center">
                            <i class="fas fa-download mr-2"></i> Download Sertifikat
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </main>

    @stack('scripts')
</body>
</html>
