<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    use HasFactory;

    // TAMBAHIN BARIS INI BRO, BIAR BISA NYIMPEN DATA
    protected $guarded = []; 
}

