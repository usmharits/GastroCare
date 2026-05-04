<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulasi_bpoms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->enum('golongan', ['Bebas', 'Bebas Terbatas', 'Keras']);
            $table->foreignId('indikasi_penyakit_id')->constrained('penyakits')->onDelete('cascade');
            $table->text('link_pembelian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulasi_bpoms');
    }
};