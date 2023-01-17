<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\data_pemilih;


class data_pemilih_controler extends Controller
{
    public function index()
    {
        return view('data_pemilih');
    }
    public function json()
    {
        return DataTables::of(data_pemilih::limit(10))->make(true);
    }
  
}
