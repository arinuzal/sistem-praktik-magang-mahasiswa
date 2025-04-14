@extends('layouts.app')

@section('title', 'Sistem Praktik Magang Mahasiswa')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-blue-900 text-white py-32">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">Sistem Praktik Magang Mahasiswa</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Platform terintegrasi untuk pengelolaan praktik magang
                mahasiswa secara efisien dan terstruktur</p>
            <div class="flex flex-col md:flex-row justify-center gap-6">
                <a href="{{ route('home') }}#praktik"
                    class="bg-white text-blue-800 px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-100 transition transform hover:scale-105 shadow-lg">
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Praktik Profesional
                    </div>
                </a>
                <a href="#recommendation"
                    class="bg-blue-600 text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition transform hover:scale-105 shadow-lg">
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Rekomendasi Mandiri
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang Praktik Section -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tentang Program Praktik Profesional</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Sistem ini dikembangkan untuk mendukung pengembangan kompetensi mahasiswa melalui pengalaman praktik di
                    dunia profesional
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-xl overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80"
                        alt="Mahasiswa Praktik" class="w-full h-auto object-cover">
                    <div class="absolute inset-0 bg-blue-800 opacity-20"></div>
                </div>

                <div>
                    <h3 class="text-2xl font-semibold mb-6 text-gray-800">Visi dan Misi Program</h3>

                    <div class="mb-8">
                        <h4 class="text-lg font-medium mb-3 text-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Visi
                        </h4>
                        <p class="text-gray-600 pl-7">
                            Menjadi program praktik profesional terdepan yang menghubungkan dunia akademik dengan industri
                            secara efektif
                        </p>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3 text-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Misi
                        </h4>
                        <ul class="space-y-3 text-gray-600 pl-7">
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Menyediakan platform terintegrasi untuk manajemen praktik profesional</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Memfasilitasi mahasiswa mendapatkan pengalaman kerja nyata</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Membangun kerjasama strategis dengan dunia industri</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pencapaian -->
            <div class="mt-16 bg-blue-50 rounded-xl p-8">
                <h3 class="text-2xl font-semibold mb-6 text-center text-gray-800">Pencapaian Program</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ([['10+ Tahun', 'Pengalaman menyelenggarakan praktik profesional'], ['50+', 'Perusahaan mitra yang bekerja sama'], ['95%', 'Tingkat kepuasan mahasiswa']] as $achievement)
                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <p class="text-3xl font-bold text-blue-600 mb-2">{{ $achievement[0] }}</p>
                            <p class="text-gray-600">{{ $achievement[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Fitur Unggulan Sistem Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ([['Pendaftaran Online', 'M5 13l4 4L19 7', 'Proses pendaftaran praktik magang yang cepat dan mudah secara online tanpa perlu antri'], ['Manajemen Dokumen', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'Sistem penyimpanan dokumen terpusat untuk semua kebutuhan administrasi'], ['Penilaian Otomatis', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'Proses penilaian praktik yang otomatis dan transparan']] as $feature)
                    <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $feature[1] }}" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-center mb-3 text-gray-800">{{ $feature[0] }}</h3>
                        <p class="text-gray-600 text-center">{{ $feature[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Praktik Profesional Section -->
    <section id="praktik" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Praktik Profesional</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Pilih periode praktik profesional sesuai dengan jadwal
                    akademik Anda</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div
                    class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:-translate-y-2">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-2xl font-bold">Semester Ganjil</h3>
                            <span class="bg-white text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">TA
                                {{ now()->year }}/{{ now()->year + 1 }}</span>
                        </div>
                        <p class="mb-6">Praktik profesional untuk semester ganjil dilaksanakan pada bulan Agustus hingga
                            Desember.</p>

                        <div class="bg-white bg-opacity-20 p-4 rounded-lg mb-6">
                            <h4 class="font-semibold mb-2">Timeline Penting:</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pendaftaran: 1-15 Agustus
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pelaksanaan: September-November
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('internship.odd') }}"
                            class="inline-block bg-white text-blue-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-500 transform hover:-translate-y-2">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-2xl font-bold">Semester Genap</h3>
                            <span class="bg-white text-green-800 px-3 py-1 rounded-full text-sm font-semibold">TA
                                {{ now()->year - 1 }}/{{ now()->year }}</span>
                        </div>
                        <p class="mb-6">Praktik profesional untuk semester genap dilaksanakan pada bulan Februari hingga
                            Juni.</p>

                        <div class="bg-white bg-opacity-20 p-4 rounded-lg mb-6">
                            <h4 class="font-semibold mb-2">Timeline Penting:</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pendaftaran: 1-15 Februari
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pelaksanaan: Maret-Mei
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('internship.even') }}"
                            class="inline-block bg-white text-green-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rekomendasi Mandiri Section -->
    <section id="recommendation" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-blue-700 text-white p-8 flex items-center">
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Rekomendasi Praktik Mandiri</h2>
                            <p class="mb-6">Proses pengajuan praktik mandiri yang mudah dan terarah</p>
                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="inline-block bg-white text-blue-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                                    Akses Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block bg-white text-blue-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                                    Login Sekarang
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="md:w-2/3 p-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Alur Pengajuan</h3>
                        <div class="space-y-6">
                            @foreach ([['Mahasiswa mengisi form rekomendasi', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'], ['Admin memverifikasi dokumen', 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'], ['Dokumen disetujui/direvisi', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'], ['Surat bisa diambil di TU', 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z']] as $step)
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $step[1] }}" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $step[0] }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">Lihat panduan lengkap untuk detail lebih
                                            lanjut</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik -->
    <section class="py-16 bg-blue-700 text-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                @foreach ([['500+', 'Mahasiswa Terdaftar'], ['95%', 'Tingkat Kepuasan'], ['50+', 'Perusahaan Mitra'], ['1000+', 'Dokumen Terproses']] as $stat)
                    <div class="p-6">
                        <p class="text-4xl font-bold mb-2">{{ $stat[0] }}</p>
                        <p>{{ $stat[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Punya pertanyaan lebih lanjut? Tim kami siap membantu Anda
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Info Kontak -->
                <div>
                    <h3 class="text-2xl font-semibold mb-6 text-gray-800">Informasi Kontak</h3>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800">Alamat</h4>
                                <p class="text-gray-600">Gedung Rektorat Lt. 3<br>Universitas Anda<br>Jl. Pendidikan No. 1,
                                    Kota Anda</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800">Telepon</h4>
                                <p class="text-gray-600">
                                    <a href="tel:+622112345678" class="hover:text-blue-600 transition">(021)
                                        1234-5678</a><br>
                                    <span class="text-sm">Senin-Jumat, 08:00-16:00 WIB</span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800">Email</h4>
                                <p class="text-gray-600">
                                    <a href="mailto:praktik@univ.ac.id"
                                        class="hover:text-blue-600 transition">praktik@univ.ac.id</a><br>
                                    <span class="text-sm">Respon dalam 1-2 hari kerja</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-lg font-medium mb-4 text-gray-800">Jam Operasional</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex justify-between max-w-xs">
                                <span>Senin-Kamis</span>
                                <span>08:00 - 16:00 WIB</span>
                            </li>
                            <li class="flex justify-between max-w-xs">
                                <span>Jumat</span>
                                <span>08:00 - 15:00 WIB</span>
                            </li>
                            <li class="flex justify-between max-w-xs">
                                <span>Sabtu-Minggu</span>
                                <span>Tutup</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Form Kontak -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-semibold mb-6 text-gray-800">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Nama Anda"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                                Email</label>
                            <input type="email" id="email" name="email" placeholder="email@anda.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                            <select id="subject" name="subject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="" disabled selected>Pilih subjek</option>
                                <option value="praktik">Informasi Praktik Profesional</option>
                                <option value="rekomendasi">Rekomendasi Mandiri</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="5" placeholder="Tulis pesan Anda..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Pertanyaan Umum</h2>
            <div class="space-y-4">
                @foreach ([['Bagaimana cara mendaftar praktik profesional?', 'Anda bisa mendaftar melalui sistem ini setelah login. Pilih periode praktik yang tersedia dan ikuti alur pendaftaran.'], ['Apa saja dokumen yang diperlukan?', 'Anda perlu menyiapkan CV, transkrip nilai, dan proposal kegiatan. Template bisa diunduh di halaman pendaftaran.'], ['Bagaimana jika saya ingin praktik mandiri?', 'Anda bisa mengajukan rekomendasi praktik mandiri melalui menu Rekomendasi Mandiri setelah login.']] as $faq)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <button class="flex justify-between items-center w-full text-left">
                            <h3 class="text-lg font-medium text-gray-800">{{ $faq[0] }}</h3>
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="mt-3 text-gray-600">
                            <p>{{ $faq[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- CTA -->
    <section class="py-16 bg-blue-800 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Memulai Praktik Profesional Anda?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Daftar sekarang dan dapatkan pengalaman praktik yang terstruktur dan
                bermanfaat</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-white text-blue-800 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-white text-blue-800 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition">
                        Login
                        <a href="{{ route('register') }}"
                            class="bg-transparent border-2 border-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-white hover:text-blue-800 transition">
                            Daftar Sekarang
                        </a>
                    </a>
                @endauth
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .animate-fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
