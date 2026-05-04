<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\FaskesController;
use App\Http\Controllers\RiwayatController;
use App\Models\Gejala;
use Illuminate\Support\Facades\Route;

// =================================================================
// 🟢 FITUR PUBLIC (BISA DIAKSES TAMU / TANPA LOGIN)
// =================================================================

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route buat nampilin form cek gejala
Route::get('/proses-diagnosa', function () {
    $gejalas = Gejala::all();
    return view('form_diagnosa', compact('gejalas'));
});

// Route buat ngeproses hitungan Certainty Factor-nya
Route::post('/diagnosa/proses', [DiagnosisController::class, 'prosesDiagnosa'])->name('diagnosa.proses');


Route::get('/food-scanner', function () { return view('food_scanner'); });
Route::post('/scan-food', [AiController::class, 'scanFood']);

// Route buat lihat Peta Faskes Terdekat
Route::get('/faskes-terdekat', [FaskesController::class, 'index']);


// =================================================================
// 🔵 FITUR PRIVATE (SATPAM: WAJIB LOGIN!)
// =================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 2. Fitur AI Chat
    Route::get('/konsultasi-ai', function () { return view('konsultasi_ai'); });
    Route::post('/chat-ai', [AiController::class, 'chat']);

    // 4. Fitur Jurnal / Tracker
    Route::get('/tracker', [TrackerController::class, 'index']);
    Route::post('/tracker/store', [TrackerController::class, 'store']);
    Route::post('/tracker/toggle/{id}', [TrackerController::class, 'toggle']);

    // 5. Fitur Riwayat & Cetak PDF
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/pdf/{id}', [RiwayatController::class, 'downloadPdf'])->name('riwayat.pdf');

});


// =================================================================
// ⚙️ FITUR PROFILE (BAWAAN BREEZE)
// =================================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';