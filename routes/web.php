<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\data_pemilih_controler;
use App\Http\Controllers\DataPemilihController;
use App\Http\Controllers\dp4Controller;
use App\Http\Controllers\DataPenetapanController;
use App\Http\Controllers\ProsesJoinTpsController;
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
})->middleware('auth');

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'authxx'])->name('authxx');

Route::middleware('auth')->group(function(){
    Route::get('/logout',[AuthController::class,'logout']);
    Route::get('/datapemilih',[data_pemilih_controler::class,'index']);
    Route::get('/datapemilih/json',[data_pemilih_controler::class,'json']);
    Route::get('/dp4/{kd_kec}/{kd_kel}/{tps}',[dp4Controller::class ,'index2']);
    Route::get('/dp4',[dp4Controller::class ,'index'])->name('dp4');
    Route::get('/dp4/kecamatan',[dp4Controller::class ,'getKecamatan']);
    Route::post('/dp4/get_kel',[dp4Controller::class ,'get_kel']);
    Route::post('/dp4/get_tps',[dp4Controller::class ,'get_tps']);
    Route::post('/dp4/import',[dp4Controller::class ,'import']);
    Route::get('dp4/set_filter_table',[dp4Controller::class ,'set_filter_dp4']);
    Route::get('/dp4/json',[dp4Controller::class,'json']);
    Route::post('/dp4/gettps2019',[dp4Controller::class,'get_tps2019']);
    Route::post('/penetapan/import',[DataPenetapanController::class ,'import']);
    Route::get('/penetapan/json',[DataPenetapanController::class,'json']);
    Route::get('/penetapan',[DataPenetapanController::class,'index'])->name('penetapan');
    Route::get('/penetapan/get_kecamatan',[DataPenetapanController::class,'get_kecamatan']);
    Route::post('/penetapan/get_kel',[DataPenetapanController::class,'get_kel']);
    Route::get('/jointps',[ProsesJoinTpsController::class,'show']);
});

