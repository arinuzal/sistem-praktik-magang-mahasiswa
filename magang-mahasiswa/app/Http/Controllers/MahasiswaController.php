<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TempatMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{

    public function create()
    {
        return view('mahasiswa.pendaftaran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|unique:mahasiswas,nim',
            'semester' => 'required|in:gasal,genap',
            'mata_kuliah' => 'required|array|min:1',
            'bukti_pembayaran' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'bukti_krs' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'video_mediasi' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'video_penyuluhan' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'nilai_magang' => 'nullable|numeric|between:0,100',
        ]);

        $buktiPembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        $buktiKrs = $request->file('bukti_krs')->store('bukti_krs', 'public');

        // Format mata kuliah
        $mataKuliahData = [];

        if ($request->semester === 'genap') {
            foreach ($request->mata_kuliah as $matkul) {
                $kelasField = 'kelas_' . str_replace(' ', '_', $matkul);

                // Normalisasi nama mata kuliah
                $namaMatkul = match($matkul) {
                    'teknik_pengurusan_perizinan' => 'Teknik Pengurusan Perizinan',
                    'teknik_pembuatan_perundangan' => 'Teknik Pembuatan Perundang-Undangan',
                    'teknik_pembuatan_kontrak' => 'Teknik Pembuatan Kontrak',
                    'penanganan_perkara_konstitusi' => 'Penanganan Perkara Konstitusi',
                    'arbitrase' => 'Arbitrase dan Alternatif Penyelesaian Sengketa',
                    default => $matkul
                };

                $mataKuliahData[] = [
                    'nama' => $namaMatkul,
                    'kelas' => $request->input($kelasField)
                ];
            }
        } else {
            foreach ($request->mata_kuliah as $matkul) {
                $mataKuliahData[] = [
                    'nama' => $matkul,
                    'kelas' => null
                ];
            }
        }

        // Encode dengan format yang konsisten
        $mataKuliahJson = json_encode($mataKuliahData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $mahasiswa = Mahasiswa::create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()->name,
            'nim' => $request->nim,
            'semester' => $request->semester,
            'mata_kuliah' => $mataKuliahJson,
            'bukti_pembayaran' => $buktiPembayaran,
            'bukti_krs' => $buktiKrs,
            'link_artikel' => $request->link_artikel,
            'status_dokumen' => 'belum dikonfirmasi',
            'status_magang' => 'belum magang',
        ]);

        if ($request->has('link_artikel')) {
            $mahasiswa->nilai_magang = 100;
            $mahasiswa->status_magang = 'selesai magang';
        }

        $jumlahTempatMagang = TempatMagang::count();
        $tempatMagangs = TempatMagang::all();

        $totalMahasiswa = Mahasiswa::count();

        $kelompok = ($totalMahasiswa - 1) % $jumlahTempatMagang;
        $tempatMagang = $tempatMagangs[$kelompok] ?? null;

        $mahasiswa->kelompok = $kelompok + 1;
        $mahasiswa->tempat_magang_id = $tempatMagang?->id;

        $mahasiswa->is_luar_biasa = $request->has('luar_biasa');
        $mahasiswa->save();

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pendaftaran berhasil.');
    }

    public function dashboard()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $isLuarBiasa = $mahasiswa->tipe === 'luar_biasa' ?? false;
        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }

    public function setSebagaiLuarBiasa()
   {
    $mahasiswa = auth()->user()->mahasiswa;
    $mahasiswa->is_luar_biasa = true;
    $mahasiswa->save();

    return back()->with('success', 'Status Mahasiswa Luar Biasa berhasil diatur.');
   }

    public function uploadLinkArtikel(Request $request)
   {
    $request->validate([
        'link_artikel' => 'required|url'
    ]);

    $mahasiswa = auth()->user()->mahasiswa;

    if (!$mahasiswa->is_luar_biasa) {
        return back()->with('error', 'Hanya mahasiswa luar biasa yang bisa unggah link.');
    }

    $mahasiswa->link_artikel = $request->link_artikel;
    $mahasiswa->nilai_magang = 100;
    $mahasiswa->status_magang = 'selesai magang';
    $mahasiswa->ceklis_artikel = true;
    $mahasiswa->save();

    return back()->with('success', 'Link artikel berhasil diunggah. Nilai otomatis diberikan.');
   }

    public function updateCeklis(Request $request)
   {
    $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();

    $mahasiswa->ceklis_penyuluhan = $request->has('penyuluhan');
    $mahasiswa->ceklis_artikel = $request->has('artikel');
    $mahasiswa->save();

    return redirect()->back()->with('success', 'Berhasil disimpan!');
    }

    public function generateSertifikat()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        if ($mahasiswa->nilai_magang < 70) {
            return redirect()->back()->with('error', 'Belum memenuhi syarat untuk sertifikat.');
        }

        $pdf = PDF::loadView('sertifikat.template', compact('mahasiswa'));
        return $pdf->download('Sertifikat_' . $mahasiswa->nama . '.pdf');
    }

    public function uploadVideo(Request $request)
{
    $request->validate([
        'video_mediasi' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
        'video_penyuluhan' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
    ]);

    $mahasiswa = auth()->user()->mahasiswa;

    if ($request->hasFile('video_mediasi')) {
        $file = $request->file('video_mediasi');
        $filename = time() . '_mediasi.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/video'), $filename);
        $mahasiswa->video_mediasi = $filename;
    }

    if ($request->hasFile('video_penyuluhan')) {
        $file = $request->file('video_penyuluhan');
        $filename = time() . '_penyuluhan.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/video'), $filename);
        $mahasiswa->video_penyuluhan = $filename;
    }

    $mahasiswa->save();

    return back()->with('success', 'Video berhasil diupload.');
}
}
