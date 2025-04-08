<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div class="col-span-1 lg:col-span-2 p-6 bg-white rounded-xl border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-primary-100 rounded-lg dark:bg-primary-900">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Selamat Datang di Sistem Praktik Magang Mahasiswa</h2>
            </div>
            <p class="mt-4 text-gray-600 dark:text-gray-300">
                Sistem ini dirancang untuk mempermudah pengelolaan magang mahasiswa. Anda dapat mengelola data mahasiswa,
                pemantauan status magang, dan penilaian secara terpadu dalam satu platform.
            </p>
        </div>

        <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg dark:bg-yellow-900">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Status Dokumen</h2>
            </div>
            <div class="mt-4 space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Belum Dikonfirmasi</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                        {{ \App\Models\Mahasiswa::where('status_dokumen', 'belum dikonfirmasi')->count() }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Disetujui</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                        {{ \App\Models\Mahasiswa::where('status_dokumen', 'disetujui')->count() }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Ditolak</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                        {{ \App\Models\Mahasiswa::where('status_dokumen', 'ditolak')->count() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-span-1 lg:col-span-2 p-6 bg-white rounded-xl border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Mahasiswa dengan Nilai Tertinggi</h2>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">NIM</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Kelompok</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach(\App\Models\Mahasiswa::orderByDesc('nilai_magang')->take(5)->get() as $mahasiswa)
                        <tr>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $mahasiswa->nama }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $mahasiswa->nim }}</td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $mahasiswa->kelompok }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $mahasiswa->nilai_magang >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    {{ $mahasiswa->nilai_magang }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
