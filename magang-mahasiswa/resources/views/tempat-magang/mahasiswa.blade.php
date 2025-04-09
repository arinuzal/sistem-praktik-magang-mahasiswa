@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">
        Mahasiswa Magang di <span class="text-blue-600">{{ $tempatMagang->nama_instansi }}</span>
    </h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if($mahasiswas->count())
        <div class="overflow-x-auto rounded-lg shadow">
            <form method="GET" class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <label for="status" class="text-gray-700 dark:text-white">Filter Status:</label>
                    <select name="status" id="status" onchange="this.form.submit()" class="border-gray-300 rounded px-3 py-2 dark:bg-gray-800 dark:text-white">
                        <option value="">-- Semua --</option>
                        <option value="belum magang" {{ request('status') == 'belum magang' ? 'selected' : '' }}>Belum Magang</option>
                        <option value="sedang magang" {{ request('status') == 'sedang magang' ? 'selected' : '' }}>Sedang Magang</option>
                        <option value="selesai magang" {{ request('status') == 'selesai magang' ? 'selected' : '' }}>Selesai Magang</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIM..."
                        class="border-gray-300 rounded px-3 py-2 w-64 dark:bg-gray-800 dark:text-white"
                    />
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Cari
                    </button>
                    <a href="{{ route('mahasiswa.export.pdf', ['status' => request('status'), 'search' => request('search')]) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Export PDF
                    </a>
                </div>
            </form>

            <table class="min-w-full divide-y divide-gray-200 bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Mata Kuliah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Nilai</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                    @foreach($mahasiswas as $mhs)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $mhs->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $mhs->nim }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white capitalize">{{ $mhs->semester }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach(json_decode($mhs->mata_kuliah, true) as $mk)
                                        <li>{{ $mk }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white capitalize">{{ $mhs->status_magang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $mhs->nilai_magang ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $mahasiswas->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <p class="text-gray-600 mt-6 dark:text-gray-300">Belum ada mahasiswa yang magang di instansi ini.</p>
    @endif
</div>
@endsection
