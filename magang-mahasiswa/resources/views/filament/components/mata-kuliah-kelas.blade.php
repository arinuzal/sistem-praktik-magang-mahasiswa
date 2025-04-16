@php
    $mataKuliah = $getState();
    $data = [];

    if (is_array($mataKuliah)) {
        $data = $mataKuliah;
    } elseif (is_string($mataKuliah) && !empty($mataKuliah)) {
        try {
            $decoded = json_decode($mataKuliah, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $data = $decoded;
            }
        } catch (\Exception $e) {
        }
    }
@endphp

@if (!empty($data))
    <ul class="list-disc list-inside space-y-1">
        @foreach ($data as $item)
            <li>
                {{ $item['nama'] ?? '-' }}
                @if(!empty($item['kelas']))
                    - Kelas {{ $item['kelas'] }}
                @endif
            </li>
        @endforeach
    </ul>
@else
    <span class="text-gray-500 italic">Data tidak tersedia</span>
@endif
