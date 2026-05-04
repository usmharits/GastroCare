<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BpomApiController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute untuk manggil API Simulasi BPOM internal
Route::get('/bpom/{penyakit_id}', [BpomApiController::class, 'getObatByPenyakit']);