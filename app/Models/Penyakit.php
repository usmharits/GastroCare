<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    // Guarded = ['id'] artinya semua kolom boleh diisi manual kecuali ID
    protected $guarded = ['id'];

    // Relasi: 1 Penyakit punya banyak Rule
    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    // Relasi: 1 Penyakit punya banyak referensi Obat BPOM
    public function simulasiBpoms()
    {
        return $this->hasMany(SimulasiBpom::class, 'indikasi_penyakit_id');
    }
}