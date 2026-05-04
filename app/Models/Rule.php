<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi kebalikan: Rule ini milik Penyakit apa?
    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    // Relasi kebalikan: Rule ini ngebahas Gejala apa?
    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}