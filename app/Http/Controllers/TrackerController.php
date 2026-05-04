<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Tracker;

class TrackerController extends Controller
{
    public function index()
    {
        // Set waktu ke WIB dan ambil tanggal hari ini
        $hariIni = now()->timezone('Asia/Jakarta')->toDateString();
        
        // Ambil semua misi untuk hari ini
        $trackers = Tracker::where('tanggal', $hariIni)->get();
        
        // Hitung Progress Bar (Persentase)
        $totalMisi = $trackers->count();
        $misiSelesai = $trackers->where('is_done', true)->count();
        $progress = $totalMisi > 0 ? round(($misiSelesai / $totalMisi) * 100) : 0;

        return view('tracker', compact('trackers', 'progress'));
    }

    // Fungsi buat dipanggil sama AI lewat AJAX
    public function store(Request $request)
    {
        Tracker::create([
            'user_id' => Auth::id(),
            'nama_misi' => $request->nama_misi,
            'is_done' => false,
            'tanggal' => now()->timezone('Asia/Jakarta')->toDateString(),
        ]);

        return response()->json(['success' => true]);
    }

    // Fungsi buat checklist / un-checklist misi
    public function toggle($id)
    {
        $tracker = Tracker::findOrFail($id);
        $tracker->is_done = !$tracker->is_done;
        $tracker->save();

        return back();
    }
}