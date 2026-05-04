<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SimulasiBpom;
use Illuminate\Http\JsonResponse;

class BpomApiController extends Controller
{
    // Fungsi ini bakal dipanggil pas mesin CF udah nemu hasil penyakitnya
    public function getObatByPenyakit($penyakit_id): JsonResponse
    {
        // Cari semua obat di tabel simulasi_bpoms yang indikasi_penyakit_id-nya cocok
        $obat = SimulasiBpom::where('indikasi_penyakit_id', $penyakit_id)->get();

        // Kalau ternyata nggak ada obat untuk penyakit itu
        if ($obat->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data obat tidak ditemukan untuk indikasi penyakit ini.',
                'data' => []
            ], 404);
        }

        // Kalau ada, return datanya dalam format JSON standar API
        return response()->json([
            'status' => 'success',
            'message' => 'Data obat berhasil diambil secara real-time dari Simulasi BPOM.',
            'data' => $obat
        ], 200);
    }
}