<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#1e3a8a',
                        dark: '#0f172a',
                        light: '#f8fafc'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Ada {{ $errors->count() }} kesalahan dalam pengisian form</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle h-5 w-5 text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Header Form -->
            <div class="bg-gradient-to-r from-primary to-secondary px-6 py-4">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-graduate mr-3"></i>
                    Pendaftaran Mahasiswa
                </h2>
                <p class="text-blue-100 mt-1 text-sm">Silakan isi form berikut dengan data yang valid</p>
            </div>

            <!-- Isi Form -->
            <div class="p-6 sm:p-8 bg-gray-50">
                <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="registrationForm">
                    @csrf

                    <!-- Toggle Mahasiswa Luar Biasa -->
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                        <input type="checkbox" name="luar_biasa" id="luar_biasa" class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                        <label for="luar_biasa" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                            Saya Mahasiswa Luar Biasa
                        </label>
                    </div>

                    <!-- Field Nama -->
                    <div class="space-y-1">
                        <label for="nama" class="block text-sm font-medium text-gray-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <!-- Field NIM -->
                    <div class="space-y-1">
                        <label for="nim" class="block text-sm font-medium text-gray-700">
                            NIM <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" name="nim" id="nim" value="{{ old('nim') }}"
                                class="pl-10 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan NIM" required>
                        </div>
                    </div>

                    <!-- Pilihan Semester -->
                    <div class="space-y-1">
                        <label for="semester" class="block text-sm font-medium text-gray-700">
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="semester" id="semester"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                required>
                                <option value="" disabled selected>Pilih Semester</option>
                                <option value="gasal" {{ old('semester') == 'gasal' ? 'selected' : '' }}>Gasal</option>
                                <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Mata Kuliah -->
                    <div class="space-y-1" id="courseSection">
                        <label class="block text-sm font-medium text-gray-700">
                            Mata Kuliah Praktik <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-500 mb-2" id="courseInstruction">Pilih semester terlebih dahulu untuk menampilkan mata kuliah</p>
                        <div id="mataKuliahContainer" class="space-y-2"></div>
                        <div id="courseError" class="hidden text-sm text-red-600 mt-1">Harap pilih minimal satu mata kuliah</div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">
                            Bukti Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-white">
                            <div class="space-y-1 text-center">
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="bukti_pembayaran" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input id="bukti_pembayaran" name="bukti_pembayaran" type="file" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF maksimal 2MB</p>
                            </div>
                        </div>
                        <div id="paymentPreview" class="mt-2 hidden">
                            <p class="text-sm text-gray-700">File terpilih: <span id="paymentFileName" class="font-medium"></span></p>
                        </div>
                    </div>

                    <!-- Bukti KRS -->
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">
                            Bukti KRS <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-white">
                            <div class="space-y-1 text-center">
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="bukti_krs" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input id="bukti_krs" name="bukti_krs" type="file" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF maksimal 2MB</p>
                            </div>
                        </div>
                        <div id="krsPreview" class="mt-2 hidden">
                            <p class="text-sm text-gray-700">File terpilih: <span id="krsFileName" class="font-medium"></span></p>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-4">
                        <button type="submit" id="submitBtn"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary to-secondary hover:from-blue-800 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menangani pemilihan semester dan menampilkan mata kuliah
        function handleSemesterChange() {
            const semesterSelect = document.getElementById('semester');
            const container = document.getElementById('mataKuliahContainer');
            const courseInstruction = document.getElementById('courseInstruction');

            container.innerHTML = '';

            if (!semesterSelect.value) {
                courseInstruction.textContent = "Pilih semester terlebih dahulu untuk menampilkan mata kuliah";
                return;
            }

            let mataKuliah = [];

            if (semesterSelect.value === 'gasal') {
                mataKuliah = ['PP Agama', 'PP Konstitusi', 'PP Perdata', 'PP Pidana', 'PP TUN'];
                courseInstruction.textContent = "Pilih mata kuliah untuk semester Gasal:";
            } else if (semesterSelect.value === 'genap') {
                mataKuliah = ['TPK', 'TPUU', 'Arbitrase dan APS', 'Teknik Pengurusan Perizinan'];
                courseInstruction.textContent = "Pilih mata kuliah untuk semester Genap:";
            }

            mataKuliah.forEach((matkul, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center p-2 hover:bg-blue-50 rounded-lg transition bg-white';

                const checkboxId = `matkul-${index}`;

                const label = document.createElement('label');
                label.className = 'flex items-center space-x-3 cursor-pointer w-full';
                label.htmlFor = checkboxId;

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'mata_kuliah[]';
                checkbox.id = checkboxId;
                checkbox.value = matkul;
                checkbox.className = 'h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500';

                // Cek jika mata kuliah ini sudah dipilih sebelumnya (setelah validasi error)
                if (Array.isArray(@json(old('mata_kuliah')))) {
                    if (@json(old('mata_kuliah')).includes(matkul)) {
                        checkbox.checked = true;
                    }
                }

                const span = document.createElement('span');
                span.className = 'text-sm text-gray-700';
                span.textContent = matkul;

                label.appendChild(checkbox);
                label.appendChild(span);
                div.appendChild(label);
                container.appendChild(div);
            });
        }

        // Inisialisasi saat dokumen siap
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk perubahan semester
            document.getElementById('semester').addEventListener('change', handleSemesterChange);

            // Jika ada nilai semester yang sudah dipilih (setelah validasi error), tampilkan mata kuliahnya
            if (@json(old('semester'))) {
                handleSemesterChange();
            }

            // Preview untuk upload file
            document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('paymentPreview');
                const fileName = document.getElementById('paymentFileName');

                if (file) {
                    preview.classList.remove('hidden');
                    fileName.textContent = file.name;
                } else {
                    preview.classList.add('hidden');
                    fileName.textContent = '';
                }
            });

            document.getElementById('bukti_krs').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('krsPreview');
                const fileName = document.getElementById('krsFileName');

                if (file) {
                    preview.classList.remove('hidden');
                    fileName.textContent = file.name;
                } else {
                    preview.classList.add('hidden');
                    fileName.textContent = '';
                }
            });

            // Validasi form sebelum submit
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                const semester = document.getElementById('semester').value;
                const checkboxes = document.querySelectorAll('input[name="mata_kuliah[]"]:checked');
                const courseError = document.getElementById('courseError');

                if (semester && checkboxes.length === 0) {
                    e.preventDefault();
                    courseError.classList.remove('hidden');
                    document.getElementById('courseSection').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else {
                    courseError.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
