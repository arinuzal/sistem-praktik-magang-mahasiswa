@php
    use Illuminate\Support\Facades\Storage;
    $url = $getState() ? Storage::url($getState()) : null;
@endphp

@if ($url)
    <a href="{{ $url }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
@else
    <span class="text-gray-500 italic">Tidak ada file</span>
@endif
