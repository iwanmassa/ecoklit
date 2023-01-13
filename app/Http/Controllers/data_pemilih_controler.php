<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class data_pemilih_controler extends Controller
{
    public function index()
    {
        return view('data_pemilih');
    }
}
