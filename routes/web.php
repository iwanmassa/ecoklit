<?php

use App\Http\Controllers\data_pemilih_controler;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'masih kosong';
});

Route::get('/datapemilih',[data_pemilih_controler::class,'index']);
