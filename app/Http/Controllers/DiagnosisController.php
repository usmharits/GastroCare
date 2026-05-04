<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Rule;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    public function prosesDiagnosa(Request $request)
    {
        // 1. VALIDASI INPUT
        // Pastikan user milih minimal 1 gejala dari Cards di UI nanti
        $request->validate([
            'gejala_id' => 'required|array|min:1',
        ], [
            'gejala_id.required' => 'Pilih minimal satu gejala terlebih dahulu.'
        ]);

        $gejalaInput = $request->gejala_id;

        // =========================================================
        // FASE 1: TRIASE GAWAT DARURAT (SHORT-CIRCUIT)
        // =========================================================
        // Cek apakah di array gejala yang dikirim ada yang is_kritis = true (misal: Muntah Darah)
        $gejalaKritis = Gejala::whereIn('id', $gejalaInput)->where('is_kritis', true)->exists();

        if ($gejalaKritis) {
            // Ambil 1 penyakit bebas (default) biar syarat database terpenuhi
            $penyakitDarurat = Penyakit::first();

            // Catat ke riwayat
            Riwayat::create([
                'user_id'       => Auth::id(), // Udah pasti login, jadi aman
                'penyakit_id'   => $penyakitDarurat->id, // Penuhi syarat database
                'cf_percentage' => 100, // Kasih aja 100% karena kondisinya kritis
                'status_triase' => 'Gawat', // Pakai kata 'Gawat' biar badge-nya warna merah di halaman Riwayat
                'tanggal'       => now()->timezone('Asia/Jakarta')->toDateString(),
            ]);

            // Hentikan semua proses! Langsung lempar peringatan ke UI (SweetAlert)
            return redirect()->back()->with('error_darurat', 'KONDISI GAWAT DARURAT: Silakan segera menuju IGD atau faskes terdekat!');
        }

        // =========================================================
        // FASE 2: MESIN INFERENSI CERTAINTY FACTOR (CF)
        // =========================================================
        $penyakits = Penyakit::with(['rules' => function ($query) use ($gejalaInput) {
            // Ambil rules yang gejalanya cocok sama inputan user aja
            $query->whereIn('gejala_id', $gejalaInput);
        }])->get();

        $hasilDiagnosa = [];

        foreach ($penyakits as $penyakit) {
            // Kalau penyakit ini nggak punya gejala yang cocok sama input user, skip aja
            if ($penyakit->rules->isEmpty()) {
                continue;
            }

            $cf_combine = 0;
            $isFirstRule = true;

            // Looping hitung CF Combine untuk setiap gejala yang cocok
            foreach ($penyakit->rules as $rule) {
                // Rumus CF Pakar = Measure of Belief (MB) - Measure of Disbelief (MD)
                $cf_pakar = $rule->mb - $rule->md;

                if ($isFirstRule) {
                    // Gejala pertama, CF Combine = CF Pakar
                    $cf_combine = $cf_pakar;
                    $isFirstRule = false;
                } else {
                    // Gejala kedua dst, pakai Rumus CF Combine:
                    // CF_Combine = CF_Lama + CF_Baru * (1 - CF_Lama)
                    $cf_combine = $cf_combine + $cf_pakar * (1 - $cf_combine);
                }
            }

            // Masukin hasil hitungan ke array
            $hasilDiagnosa[] = [
                'penyakit_id' => $penyakit->id,
                'nama_penyakit' => $penyakit->nama_penyakit,
                'cf_percentage' => round($cf_combine * 100, 2) // Jadikan persen (contoh: 84.50%)
            ];
        }

        // Kalau ternyata nilai CF-nya kosong/nggak valid
        if (empty($hasilDiagnosa)) {
            return redirect()->back()->with('info', 'Gejala tidak spesifik mengarah ke gangguan lambung.');
        }

        // =========================================================
        // FASE 3: SORTING HASIL TERTINGGI
        // =========================================================
        // Urutkan array dari persentase CF terbesar ke terkecil
        usort($hasilDiagnosa, function ($a, $b) {
            return $b['cf_percentage'] <=> $a['cf_percentage'];
        });

        // Ambil penyakit dengan probabilitas paling tinggi (peringkat 1)
        $penyakitTertinggi = $hasilDiagnosa[0];

        // =========================================================
        // FASE 4: INTEGRASI API BPOM INTERNAL & FILTERING OBAT
        // =========================================================
        // Tembak URL API yang udah kita bikin di langkah sebelumnya
        $apiUrl = url('http://127.0.0.1:8001/api/bpom/' . $penyakitTertinggi['penyakit_id']);
        $response = Http::get($apiUrl);

        $obatAman = [];
        $obatKeras = [];

        if ($response->successful()) {
            $dataBpom = $response->json()['data'];

            // Klasifikasikan obat sesuai regulasi e-farmasi
            foreach ($dataBpom as $obat) {
                if (in_array($obat['golongan'], ['Bebas', 'Bebas Terbatas'])) {
                    $obatAman[] = $obat; // Masuk kategori swamedikasi aman
                } elseif ($obat['golongan'] === 'Keras') {
                    $obatKeras[] = $obat; // Masuk kategori wajib resep (label merah)
                }
            }
        }
// =========================================================
        // FASE 5: SIMPAN RIWAYAT & RETURN KE VIEW
        // =========================================================
        
        // 1. Kita "tembak" dulu ke database buat nyari data penyakit asli berdasarkan namanya
        $dataPenyakit = \App\Models\Penyakit::where('nama_penyakit', $penyakitTertinggi['nama_penyakit'])->first();

        // 2. Baru deh kita simpan riwayatnya pakai ID yang udah ketemu
        Riwayat::create([
            'user_id'       => Auth::id(),
            'penyakit_id'   => $dataPenyakit->id, // Nah, sekarang ID-nya pasti dapet!
            'cf_percentage' => $penyakitTertinggi['cf_percentage'],
            'status_triase' => 'Aman',
            'tanggal'       => now()->timezone('Asia/Jakarta')->toDateString(),
        ]);
        
        // Lempar semua data ke halaman Hasil Analisis
        return view('hasil_diagnosa', [
            'diagnosa' => $penyakitTertinggi,
            'obatAman' => $obatAman,
            'obatKeras' => $obatKeras
        ]);
    }
}