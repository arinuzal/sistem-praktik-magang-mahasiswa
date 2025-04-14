@php
    $mataKuliah = json_decode($getState(), true);
@endphp

@if (is_array($mataKuliah))
    <ul class="list-disc list-inside space-y-1">
        @foreach ($mataKuliah as $item)
            <li>{{ $item['nama'] ?? '-' }}{{ isset($item['kelas']) ? ' - Kelas: ' . $item['kelas'] : '' }}</li>
        @endforeach
    </ul>
@else
    <span class="text-gray-500 italic">Data tidak tersedia</span>
@endif
