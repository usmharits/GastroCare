<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulasiBpom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi kebalikan: Obat ini indikasinya buat Penyakit apa?
    public function indikasiPenyakit()
    {
        return $this->belongsTo(Penyakit::class, 'indikasi_penyakit_id');
    }
}