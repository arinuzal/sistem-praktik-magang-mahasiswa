@extends('layouts.app')

@section('title', 'Praktik Profesional Semester Genap')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('internship.index') }}" class="ml-1 text-sm font-medium text-blue-600 hover:text-blue-800 md:ml-2">Praktik Profesional</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Semester Genap</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Header Section -->
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-green-800 mb-2">Praktik Profesional Semester Genap</h1>
                    <p class="text-gray-600">TA {{ now()->year-1 }}/{{ now()->year }}</p>
                    <div class="mt-4">
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Periode: Februari - Juni {{ now()->year }}
                        </span>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Timeline Kegiatan</h2>
                    <div class="relative">
                        <!-- Timeline Bar -->
                        <div class="h-2 bg-gray-200 rounded-full mb-6">
                            <div class="h-full bg-green-600 rounded-full" style="width: 40%"></div>
                        </div>

                        <!-- Timeline Items -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            @foreach([
                                ['Pendaftaran', '1-15 Februari', 'bg-green-600'],
                                ['Penempatan', '16-25 Februari', 'bg-green-600'],
                                ['Pelaksanaan', '1 Maret - 31 Mei', 'bg-green-400'],
                                ['Penilaian', '1-15 Juni', 'bg-green-300']
                            ] as $item)
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $item[2] }}"></div>
                                <div class="timeline-content">
                                    <h3 class="font-bold">{{ $item[0] }}</h3>
                                    <p>{{ $item[1] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Persyaratan -->
                <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Persyaratan</h2>
                    <div class="bg-green-50 p-6 rounded-lg">
                        <ul class="list-disc pl-5 space-y-2">
                            @foreach([
                                'Mahasiswa aktif minimal semester 4',
                                'IPK minimal 2.50',
                                'Mengisi formulir pendaftaran online',
                                'Menyertakan transkrip nilai terakhir',
                                'Surat rekomendasi dari dosen pembimbing',
                                'Membuat proposal kegiatan (minimal 5 halaman)'
                            ] as $requirement)
                            <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                 <!-- Dokumen -->
                 <div class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dokumen</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach([
                            ['Panduan Praktik', 'Petunjuk lengkap pelaksanaan praktik profesional semester ganjil'],
                            ['Formulir Pendaftaran', 'Formulir resmi untuk pendaftaran praktik'],
                            ['Template Proposal', 'Format standar untuk pembuatan proposal']
                        ] as $document)
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center mb-2">
                                <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="font-semibold">{{ $document[0] }}</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">{{ $document[1] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="text-center mt-8">
                    @auth
                        @if(auth()->user()->role == 'mahasiswa')
                            @if(now()->month >= 1 && now()->month <= 2)
                                <a href="{{ route('dashboard') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-md font-medium hover:bg-green-700 transition">
                                    Daftar Sekarang
                                </a>
                            @else
                                <p class="text-gray-600">Pendaftaran akan dibuka bulan Februari</p>
                            @endif
                        @endif
                    @else
                        <div>
                            <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk mendaftar</p>
                            <a href="{{ route('login') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-md font-medium hover:bg-green-700 transition">
                                Login
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline-item {
        position: relative;
        padding-left: 2rem;
    }
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
    }
    .timeline-content {
        padding: 0.5rem;
    }
</style>
@endpush
