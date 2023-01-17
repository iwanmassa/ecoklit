<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenetapan extends Model
{
    use HasFactory;
    protected $table = "data_penetapan";
    protected $fillable = [
        'dpid',
        'nkk',
        'nik',
        'nama',
        'tempat_lahir','tgl_lahir','jenis_kelamin','status','alamat','rt','rw','disabilitas','kd_kec','nama_kec','kd_kel','nama_kel','tps','tps_new','ket',
    ];
    public $timestamps = false;
}
