<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('trackers', function (Blueprint $table) {
        $table->id();
        $table->string('nama_misi');
        $table->boolean('is_done')->default(false); // Buat ngecek udah dichecklist belum
        $table->date('tanggal'); // Biar misinya ke-reset tiap ganti hari
        $table->timestamps();
    });
}

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackers');
    }
};
