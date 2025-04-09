<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempatMagang;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TempatMagangController extends Controller
{
    public function mahasiswaMagang(Request $request)
    {
        $user = Auth::user();
        $tempatMagang = TempatMagang::where('user_id', $user->id)->firstOrFail();

        $status = $request->status;

        $query = Mahasiswa::where('tempat_magang_id', $tempatMagang->id);

        if ($status) {
            $query->where('status_magang', $status);
        }

        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        $mahasiswas = $query->paginate(10);

        return view('tempat-magang.mahasiswa', compact('mahasiswas', 'tempatMagang'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $tempatMagang = TempatMagang::where('user_id', $user->id)->firstOrFail();

        $status = $request->status;

        $query = Mahasiswa::where('tempat_magang_id', $tempatMagang->id);

        if ($status) {
            $query->where('status_magang', $status);
        }

        $mahasiswas = $query->get();

        $pdf = Pdf::loadView('tempat-magang.pdf', compact('mahasiswas', 'tempatMagang'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('daftar-mahasiswa-magang.pdf');
    }
}
