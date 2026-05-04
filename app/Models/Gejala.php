<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: 1 Gejala bisa ada di banyak Rule
    public function rules()
    {
        return $this->hasMany(Rule::class);
    }
}