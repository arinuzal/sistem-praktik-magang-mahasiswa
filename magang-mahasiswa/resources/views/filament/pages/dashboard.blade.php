<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Welcome Card --}}
        <div class="col-span-1 lg:col-span-2 p-6 bg-white rounded-xl border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 transition hover:ring-2 hover:ring-primary-300 dark:hover:ring-primary-500">
            <div class="flex items-center">
                <div class="p-2 bg-primary-100 rounded-lg dark:bg-primary-900">
                    <x-heroicon-o-information-circle class="w-6 h-6 text-primary-600 dark:text-primary-400"/>
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Selamat Datang di Sistem Praktik Magang Mahasiswa</h2>
            </div>
            <p class="mt-4 text-gray-600 dark:text-gray-300 text-pretty">
                Sistem ini dirancang untuk mempermudah pengelolaan magang mahasiswa. Anda dapat mengelola data mahasiswa, memantau status dokumen, hingga melihat capaian nilai magang dalam satu platform.
            </p>
        </div>

        {{-- Total Mahasiswa --}}
        <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 transition hover:ring-2 hover:ring-blue-300 dark:hover:ring-blue-600">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg dark:bg-blue-900">
                    <x-heroicon-o-user-group class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Total Mahasiswa</h2>
            </div>
            <p class="mt-4 text-3xl font-bold text-gray-700 dark:text-gray-200">
                {{ \App\Models\Mahasiswa::count() }}
            </p>
        </div>

        {{-- Status Dokumen --}}
        <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 transition hover:ring-2 hover:ring-yellow-300 dark:hover:ring-yellow-600">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg dark:bg-yellow-900">
                    <x-heroicon-o-document-text class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Status Dokumen</h2>
            </div>
            <div class="mt-4 space-y-3">
                @php
                    $statuses = [
                        'Belum Dikonfirmasi' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                        'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    ];
                @endphp

                @foreach($statuses as $label => $style)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">{{ $label }}</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $style }}">
                        {{ \App\Models\Mahasiswa::where('status_dokumen', strtolower($label))->count() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Progress Bar Magang --}}
        <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Progress Magang</h2>
            @php
                $total = \App\Models\Mahasiswa::count();
                $sudah = \App\Models\Mahasiswa::where('status_magang', 'selesai magang')->count();
                $progress = $total > 0 ? round(($sudah / $total) * 100) : 0;
            @endphp
            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                <div class="bg-green-500 h-4 rounded-full transition-all" style="width: {{ $progress }}%"></div>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $progress }}% dari mahasiswa telah menyelesaikan magang</p>
        </div>

        {{-- Mahasiswa dengan Nilai Tertinggi --}}
        <div class="col-span-1 lg:col-span-3 p-6 bg-white rounded-xl border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg dark:bg-green-900">
                    <x-heroicon-o-academic-cap class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">Mahasiswa dengan Nilai Tertinggi</h2>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700">
                            <th class="px-3 py-3 text-left font-medium text-gray-600 uppercase dark:text-gray-300">Nama</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-600 uppercase dark:text-gray-300">NIM</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-600 uppercase dark:text-gray-300">Kelompok</th>
                            <th class="px-3 py-3 text-left font-medium text-gray-600 uppercase dark:text-gray-300">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach(\App\Models\Mahasiswa::orderByDesc('nilai_magang')->take(5)->get() as $mahasiswa)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-3 py-2 text-gray-800 dark:text-gray-200 whitespace-nowrap">{{ $mahasiswa->nama }}</td>
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ $mahasiswa->nim }}</td>
                            <td class="px-3 py-2 text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ $mahasiswa->kelompok }}</td>
                            <td class="px-3 py-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $mahasiswa->nilai_magang >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
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
