<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dp4 extends Model
{
    use HasFactory;
    protected $table = 'dp4';
    protected $fillable = [
        'nkk',
        'nik',
        'nama',
        'tempat_lahir','tgl_lahir','jenis_kelamin','status','alamat','rt','rw','disabilitas','kd_kec','nama_kec','kd_kel','nama_kel','tps','ket',
    ];
    public $timestamps = false;
}
