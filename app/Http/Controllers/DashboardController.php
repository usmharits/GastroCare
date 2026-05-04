<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Wajib dipanggil biar bisa ngecek ID user!

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mesin Pengacak Tips Harian
        $daftarTips = [
            "Beri jeda 2-3 jam setelah makan sebelum rebahan biar asam lambung nggak naik ke kerongkongan.",
            "Kunyah makanan pelan-pelan sampai hancur. Kasihan lambungmu kalau disuruh giling makanan keras!",
            "Hindari minum air terlalu banyak di sela-sela mengunyah, lebih baik minum setelah makan selesai.",
            "Kurangi makanan super pedas, asam, dan berlemak tinggi kalau perut lagi terasa kurang nyaman.",
            "Kelola stres dengan baik! Pikiran yang ruwet dan overthinking itu pemicu utama asam lambung naik lho.",
            "Gunakan bantal penyangga yang lebih tinggi (posisi kepala lebih tinggi dari perut) saat tidur malam.",
            "Biasakan makan dengan porsi kecil tapi sering, daripada makan porsi kuli tapi cuma sekali sehari."
        ];
        $tipHariIni = $daftarTips[array_rand($daftarTips)];

        // Ambil ID User yang lagi login
        $userId = Auth::id();

        // =================================================================
        // 2. Data buat Pie Chart (Distribusi Keseluruhan) - KHUSUS USER INI
        // =================================================================
        $riwayatPenyakit = Riwayat::where('user_id', $userId) // <-- INI FILTERNYA BRO!
            ->selectRaw('penyakit_id, count(*) as total')
            ->groupBy('penyakit_id')
            ->with('penyakit')
            ->get();

        $pieLabels = [];
        $pieData = [];
        foreach($riwayatPenyakit as $rp) {
            $pieLabels[] = $rp->penyakit->nama_penyakit;
            $pieData[] = $rp->total;
        }

        // =================================================================
        // 3. Data buat Line Chart (Tren Kepastian/CF 7 Analisis Terakhir)
        // =================================================================
        $riwayatTerakhir = Riwayat::where('user_id', $userId) // <-- FILTER LAGI!
            ->latest()
            ->take(7)
            ->get()
            ->reverse(); 
            
        $lineLabels = [];
        $lineData = [];
        foreach($riwayatTerakhir as $rt) {
            $lineLabels[] = Carbon::parse($rt->tanggal)->format('d/m');
            $lineData[] = $rt->cf_percentage;
        }

        // =================================================================
        // 4. Data buat Stacked Bar Chart (Frekuensi Harian Bulan Ini)
        // =================================================================
        $bulanIni = Carbon::now('Asia/Jakarta')->month;
        $tahunIni = Carbon::now('Asia/Jakarta')->year;

        // Ambil data bulan ini KHUSUS buat user yang login
        $riwayatBulanIni = Riwayat::with('penyakit')
            ->where('user_id', $userId) // <-- FILTER LAGI DAN LAGI!
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->orderBy('tanggal')
            ->get();

        $groupedData = [];
        $penyakitUnik = [];

        // Kelompokkin data per Tanggal -> Nama Penyakit -> Jumlah Cek
        foreach ($riwayatBulanIni as $r) {
            $tgl = Carbon::parse($r->tanggal)->format('d M'); 
            $namaPenyakit = $r->penyakit->nama_penyakit;

            if (!in_array($namaPenyakit, $penyakitUnik)) {
                $penyakitUnik[] = $namaPenyakit;
            }

            if (!isset($groupedData[$tgl])) {
                $groupedData[$tgl] = [];
            }

            if (!isset($groupedData[$tgl][$namaPenyakit])) {
                $groupedData[$tgl][$namaPenyakit] = 0;
            }

            $groupedData[$tgl][$namaPenyakit]++;
        }

        $barLabels = array_keys($groupedData); 
        $barDatasets = [];
        
        $warna = ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#14b8a6'];

        foreach ($penyakitUnik as $index => $penyakit) {
            $dataCounts = [];
            foreach ($barLabels as $tgl) {
                $dataCounts[] = $groupedData[$tgl][$penyakit] ?? 0;
            }

            $barDatasets[] = [
                'label' => $penyakit,
                'data' => $dataCounts,
                'backgroundColor' => $warna[$index % count($warna)],
                'borderRadius' => 4, 
            ];
        }

        return view('dashboard', compact(
            'tipHariIni', 
            'pieLabels', 'pieData', 
            'lineLabels', 'lineData',
            'barLabels', 'barDatasets' 
        ));
    }
}