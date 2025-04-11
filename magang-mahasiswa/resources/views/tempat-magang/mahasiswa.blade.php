<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa Magang - {{ $tempatMagang->nama_instansi }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .dark {
            --color-primary-600: #2563eb;
            --color-primary-700: #1d4ed8;
            --color-success-600: #16a34a;
            --color-success-700: #15803d;
            --color-warning-600: #d97706;
            --color-warning-700: #b45309;
            --color-danger-600: #dc2626;
            --color-danger-700: #b91c1c;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-200">
<!-- Navigation Bar -->
<nav class="bg-white dark:bg-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-user-graduate mr-2"></i>Sistem Magang
                </span>
            </div>
            <div class="flex items-center">
                <div class="ml-4 relative">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 text-xs"></i>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                Mahasiswa Magang di <span class="text-primary-600 dark:text-primary-500">{{ $tempatMagang->nama_instansi }}</span>
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Total: {{ $mahasiswas->total() }} mahasiswa
            </p>
        </div>

        <a href="{{ route('mahasiswa.export.pdf', ['status' => request('status'), 'search' => request('search')]) }}"
           class="inline-flex items-center px-4 py-2 bg-success-600 dark:bg-success-700 text-white rounded-md hover:bg-success-700 dark:hover:bg-success-800 transition-colors">
            <i class="fas fa-file-pdf mr-2"></i> Export PDF
        </a>
    </div>

    <!-- Notification -->
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md flex items-start dark:bg-red-900 dark:border-red-700 dark:text-red-100">
            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-300 mr-3 mt-1"></i>
            <div>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if($mahasiswas->count())
        <!-- Filter and Search Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
            <form method="GET" class="space-y-4 md:space-y-0 md:flex md:items-center md:justify-between gap-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-2">
                        <label for="status" class="whitespace-nowrap">Filter Status:</label>
                        <select name="status" id="status" onchange="this.form.submit()"
                            class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Semua Status</option>
                            <option value="belum magang" {{ request('status') == 'belum magang' ? 'selected' : '' }}>Belum Magang</option>
                            <option value="sedang magang" {{ request('status') == 'sedang magang' ? 'selected' : '' }}>Sedang Magang</option>
                            <option value="selesai magang" {{ request('status') == 'selesai magang' ? 'selected' : '' }}>Selesai Magang</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama/NIM..."
                            class="pl-10 w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <button type="submit"
                        class="bg-primary-600 dark:bg-primary-700 text-white px-4 py-2 rounded-md hover:bg-primary-700 dark:hover:bg-primary-800 transition-colors flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Semester</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mata Kuliah</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($mahasiswas as $mhs)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $mhs->nama }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $mhs->nim }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 capitalize">
                                    {{ $mhs->semester }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach(json_decode($mhs->mata_kuliah, true) as $mk)
                                            <li class="break-words">{{ $mk }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'belum magang' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'sedang magang' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'selesai magang' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                    ];
                                    $statusClass = $statusClasses[$mhs->status_magang] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }} capitalize">
                                    {{ $mhs->status_magang }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($mhs->nilai_magang)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $mhs->nilai_magang >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                           ($mhs->nilai_magang >= 60 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                                           'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                        {{ $mhs->nilai_magang }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $mahasiswas->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-user-graduate text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada mahasiswa magang</h3>
            <p class="text-gray-500 dark:text-gray-400">Tidak ada mahasiswa yang terdaftar magang di instansi ini saat ini.</p>
        </div>
    @endif
</div>
</body>
</html>
