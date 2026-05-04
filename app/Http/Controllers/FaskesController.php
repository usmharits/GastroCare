<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaskesController extends Controller
{
    public function index()
    {
        return view('peta_faskes');
    }
}