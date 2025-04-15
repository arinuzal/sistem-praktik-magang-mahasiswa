@php
    $mataKuliah = $getState();
    $data = [];

    if (is_array($mataKuliah)) {
        if (isset($mataKuliah[0]) && is_array($mataKuliah[0])) {
            $data = $mataKuliah;
        } else {
            foreach ($mataKuliah as $item) {
                if (is_string($item)) {
                    $parts = explode('_', $item);
                    $kelas = array_pop($parts);
                    $nama = str_replace('_', ' ', implode('_', $parts));
                    $data[] = ['nama' => $nama, 'kelas' => $kelas];
                }
            }
        }
    } elseif (is_string($mataKuliah)) {
        try {
            $decoded = json_decode($mataKuliah, true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        } catch (\Exception $e) {
            $data = [];
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
