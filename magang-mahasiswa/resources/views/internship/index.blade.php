@extends('layouts.app')

@section('title', 'Praktik Profesional')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Praktik Profesional</h1>
            <p class="text-lg text-gray-600">Pilih periode praktik profesional yang tersedia</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="bg-blue-600 p-4 text-white">
                    <h2 class="text-xl font-bold">Semester Ganjil</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Praktik profesional untuk semester ganjil dilaksanakan pada bulan Agustus hingga Desember.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-blue-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Pendaftaran: Agustus</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-blue-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Pelaksanaan: September-November</span>
                        </li>
                    </ul>
                    <a href="{{ route('internship.odd') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Lihat Detail</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="bg-green-600 p-4 text-white">
                    <h2 class="text-xl font-bold">Semester Genap</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Praktik profesional untuk semester genap dilaksanakan pada bulan Februari hingga Juni.</p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Pendaftaran: Februari</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Pelaksanaan: Maret-Mei</span>
                        </li>
                    </ul>
                    <a href="{{ route('internship.even') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
