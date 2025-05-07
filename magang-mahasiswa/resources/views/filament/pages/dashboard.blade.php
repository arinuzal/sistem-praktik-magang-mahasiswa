<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 lg:gap-6 lg:grid-cols-3">
        {{-- Welcome Card --}}
        <div class="col-span-1 lg:col-span-2 fi-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-card-header p-6">
                <div class="flex items-center gap-x-3">
                    <div class="fi-icon-btn bg-primary-50 text-primary-600 dark:bg-gray-800 dark:text-primary-400 p-3 rounded-lg">
                        <x-heroicon-o-academic-cap class="w-6 h-6"/>
                    </div>
                    <h2 class="fi-card-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                        Selamat Datang di Sistem Praktik Magang Mahasiswa
                    </h2>
                </div>
            </div>

            <div class="fi-card-content p-6 pt-0">
                <p class="text-gray-600 dark:text-gray-400 text-pretty">
                    Sistem ini dirancang untuk mempermudah pengelolaan magang mahasiswa. Anda dapat mengelola data mahasiswa, memantau status dokumen, hingga melihat capaian nilai magang dalam satu platform.
                </p>

                @php
                    $totalMahasiswa = \App\Models\Mahasiswa::count();
                    $totalLuarBiasa = \App\Models\Mahasiswa::where('is_luar_biasa', true)->count();
                    $persenLuarBiasa = $totalMahasiswa > 0 ? round(($totalLuarBiasa / $totalMahasiswa) * 100) : 0;
                    $avgNilai = \App\Models\Mahasiswa::whereNotNull('nilai_magang')->avg('nilai_magang') ?? 0;
                @endphp

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="fi-stat bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <div class="fi-stat-value text-2xl font-bold text-gray-950 dark:text-white">
                            {{ $totalMahasiswa }}
                        </div>
                        <div class="fi-stat-label text-sm text-gray-500 dark:text-gray-400">
                            Total Mahasiswa
                        </div>
                    </div>
                    <div class="fi-stat bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <div class="fi-stat-value text-2xl font-bold text-gray-950 dark:text-white">
                            {{ $totalLuarBiasa }} <span class="text-sm text-primary-600 dark:text-primary-400">({{ $persenLuarBiasa }}%)</span>
                        </div>
                        <div class="fi-stat-label text-sm text-gray-500 dark:text-gray-400">
                            Mahasiswa Luar Biasa
                        </div>
                    </div>
                    <div class="fi-stat bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <div class="fi-stat-value text-2xl font-bold text-gray-950 dark:text-white">
                            {{ number_format($avgNilai, 1) }}
                        </div>
                        <div class="fi-stat-label text-sm text-gray-500 dark:text-gray-400">
                            Rata-rata Nilai
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="space-y-4">
            {{-- Total Mahasiswa by Status --}}
            <div class="fi-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-card-header p-6">
                    <div class="flex items-center gap-x-3">
                        <div class="fi-icon-btn bg-blue-50 text-blue-600 dark:bg-gray-800 dark:text-blue-400 p-2 rounded-lg">
                            <x-heroicon-o-user-group class="w-6 h-6"/>
                        </div>
                        <h2 class="fi-card-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                            Status Magang
                        </h2>
                    </div>
                </div>

                <div class="fi-card-content p-6 pt-0">
                    <div class="space-y-3">
                        @php
                            $statusMagang = [
                                'belum magang' => ['count' => \App\Models\Mahasiswa::where('status_magang', 'belum magang')->count(), 'color' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'],
                                'sedang magang' => ['count' => \App\Models\Mahasiswa::where('status_magang', 'sedang magang')->count(), 'color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'],
                                'selesai magang' => ['count' => \App\Models\Mahasiswa::where('status_magang', 'selesai magang')->count(), 'color' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'],
                            ];
                        @endphp

                        @foreach($statusMagang as $status => $data)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400 capitalize">{{ $status }}</span>
                            <span class="fi-badge px-2 py-1 text-xs font-medium rounded-full {{ $data['color'] }}">
                                {{ $data['count'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Status Dokumen --}}
            <div class="fi-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-card-header p-6">
                    <div class="flex items-center gap-x-3">
                        <div class="fi-icon-btn bg-yellow-50 text-yellow-600 dark:bg-gray-800 dark:text-yellow-400 p-2 rounded-lg">
                            <x-heroicon-o-document-text class="w-6 h-6"/>
                        </div>
                        <h2 class="fi-card-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                            Status Dokumen
                        </h2>
                    </div>
                </div>

                <div class="fi-card-content p-6 pt-0">
                    <div class="space-y-3">
                        @php
                            $statuses = [
                                'belum dikonfirmasi' => ['label' => 'Belum Dikonfirmasi', 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'],
                                'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'],
                                'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'],
                            ];
                        @endphp

                        @foreach($statuses as $status => $data)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ $data['label'] }}</span>
                            <span class="fi-badge px-2 py-1 text-xs font-medium rounded-full {{ $data['class'] }}">
                                {{ \App\Models\Mahasiswa::where('status_dokumen', $status)->count() }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress Bar Magang --}}
        <div class="col-span-1 lg:col-span-2 fi-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-card-header p-6">
                <h2 class="fi-card-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                    Progress Magang
                </h2>
            </div>

            <div class="fi-card-content p-6 pt-0">
                @php
                    $total = \App\Models\Mahasiswa::count();
                    $belumMagang = \App\Models\Mahasiswa::where('status_magang', 'belum magang')->count();
                    $sedangMagang = \App\Models\Mahasiswa::where('status_magang', 'sedang magang')->count();
                    $selesaiMagang = \App\Models\Mahasiswa::where('status_magang', 'selesai magang')->count();

                    $persenBelum = $total > 0 ? round(($belumMagang / $total) * 100) : 0;
                    $persenSedang = $total > 0 ? round(($sedangMagang / $total) * 100) : 0;
                    $persenSelesai = $total > 0 ? round(($selesaiMagang / $total) * 100) : 0;
                @endphp

                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-300 dark:text-gray-300">Status Keseluruhan</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700">
                        <div class="flex">
                            <div class="bg-red-500 h-2 transition-all" style="width: {{ $persenBelum }}%"></div>
                            <div class="bg-yellow-500 h-2 transition-all" style="width: {{ $persenSedang }}%"></div>
                            <div class="bg-green-500 h-2 transition-all" style="width: {{ $persenSelesai }}%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div>
                            <span>Belum Magang ({{ $persenBelum }}%)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                            <span>Sedang Magang ({{ $persenSedang }}%)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                            <span>Selesai Magang ({{ $persenSelesai }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Distribusi Semester --}}
        <div class="fi-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-card-header p-6">
                <h2 class="fi-card-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                    Distribusi Semester
                </h2>
            </div>

            <div class="fi-card-content p-6 pt-0">
                @php
                    $semesters = \App\Models\Mahasiswa::select('semester')
                        ->selectRaw('count(*) as total')
                        ->groupBy('semester')
                        ->orderBy('semester')
                        ->get();
                @endphp

                <div class="space-y-4">
                    @foreach($semesters as $semester)
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-300 dark:text-gray-300">Semester {{ $semester->semester }}</span>
                            <span class="text-sm font-medium text-gray-300 dark:text-gray-300">{{ $semester->total }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: {{ ($semester->total / $totalMahasiswa) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Mahasiswa dengan Nilai Tertinggi --}}
        <div class="col-span-1 lg:col-span-3 fi-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-card-header p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-x-3">
                        <div class="fi-icon-btn bg-green-50 text-green-600 dark:bg-gray-800 dark:text-green-400 p-2 rounded-lg">
                            <x-heroicon-o-star class="w-6 h-6"/>
                        </div>
                        <h2 class="fi-card-header-heading text-xl font-semibold leading-6 text-gray-950 dark:text-white">
                            Mahasiswa dengan Nilai Tertinggi
                        </h2>
                    </div>

                </div>
            </div>

            <div class="fi-card-content p-6 pt-0">
                <div class="overflow-x-auto">
                    <table class="fi-table w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="fi-table-header-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nama</th>
                                <th class="fi-table-header-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">NIM</th>
                                <th class="fi-table-header-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Semester</th>
                                <th class="fi-table-header-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status Magang</th>
                                <th class="fi-table-header-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach(\App\Models\Mahasiswa::whereNotNull('nilai_magang')->orderByDesc('nilai_magang')->take(5)->get() as $mahasiswa)
                            <tr>
                                <td class="fi-table-cell px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $mahasiswa->nama }}
                                            @if($mahasiswa->is_luar_biasa)
                                                <span class="ml-1 fi-badge px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                                    LB
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="fi-table-cell px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $mahasiswa->nim }}
                                </td>
                                <td class="fi-table-cell px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $mahasiswa->semester }}
                                </td>
                                <td class="fi-table-cell px-4 py-3 whitespace-nowrap">
                                    <span class="fi-badge px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $mahasiswa->status_magang === 'selesai magang' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                                           ($mahasiswa->status_magang === 'sedang magang' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                                           'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                        {{ ucfirst($mahasiswa->status_magang) }}
                                    </span>
                                </td>
                                <td class="fi-table-cell px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium
                                            {{ $mahasiswa->nilai_magang >= 85 ? 'text-green-600 dark:text-green-400' :
                                               ($mahasiswa->nilai_magang >= 70 ? 'text-yellow-600 dark:text-yellow-400' :
                                               'text-red-600 dark:text-red-400') }}">
                                            {{ $mahasiswa->nilai_magang }}
                                        </span>
                                        <div class="ml-2 flex-shrink-0">
                                            @if($mahasiswa->nilai_magang >= 85)
                                                <x-heroicon-s-star class="h-4 w-4 text-yellow-400" />
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
