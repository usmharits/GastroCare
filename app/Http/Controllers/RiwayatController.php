<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil riwayat terbaru di atas
        $riwayats = Riwayat::with('penyakit')->latest()->get();
        return view('riwayat_index', compact('riwayats'));
    }

    public function downloadPdf($id)
    {
        $data = Riwayat::with('penyakit')->findOrFail($id);
        
        // Load view khusus untuk format kertas PDF
        $pdf = Pdf::loadView('pdf_laporan', compact('data'));
        
        return $pdf->download('Laporan_Kesehatan_'.$data->tanggal.'.pdf');
    }
}