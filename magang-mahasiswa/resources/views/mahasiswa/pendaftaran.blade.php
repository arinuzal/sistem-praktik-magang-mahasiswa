@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger p-2 rounded">
        <ul class="text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl text-white font-bold text-gray-800 mb-6">Pendaftaran Mahasiswa</h2>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <label class="flex items-center">
                <input type="checkbox" name="luar_biasa" class="mr-2">
                Saya Mahasiswa Luar Biasa
            </label>

            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="nama"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nama') }}" required>
            </div>

            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input type="text" name="nim" id="nim"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nim') }}" required>
            </div>

            <div>
                <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester" id="semester"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required onchange="handleSemester(this)">
                    <option value="">Pilih Semester</option>
                    <option value="gasal">Gasal</option>
                    <option value="genap">Genap</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah Praktik</label>
                <div id="mataKuliahContainer" class="mt-2 space-y-2"></div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                <div class="mt-1 flex items-center">
                    <input type="file" name="bukti_pembayaran"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti KRS</label>
                <div class="mt-1 flex items-center">
                    <input type="file" name="bukti_krs"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Daftar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleSemester(select) {
        const container = document.getElementById('mataKuliahContainer');
        container.innerHTML = '';
        let mataKuliah = [];

        if (select.value === 'gasal') {
            mataKuliah = ['PP Agama', 'PP Konstitusi', 'PP Perdata', 'PP Pidana', 'PP TUN'];
        } else if (select.value === 'genap') {
            mataKuliah = ['TPK', 'TPUU', 'Arbitrase dan APS', 'Teknik Pengurusan Perizinan'];
        }

        mataKuliah.forEach(matkul => {
            const div = document.createElement('div');
            div.className = 'flex items-center';

            const label = document.createElement('label');
            label.className = 'flex items-center space-x-3 cursor-pointer';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'mata_kuliah[]';
            checkbox.value = matkul;
            checkbox.className = 'h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500';

            const span = document.createElement('span');
            span.className = 'text-sm text-gray-700';
            span.textContent = matkul;

            label.appendChild(checkbox);
            label.appendChild(span);
            div.appendChild(label);
            container.appendChild(div);
        });
    }
</script>
@endsection
