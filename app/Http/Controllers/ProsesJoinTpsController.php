<?php

namespace App\Http\Controllers;

use App\Models\DataPenetapan;
use App\Models\dp4;

class ProsesJoinTpsController extends Controller
{
    public function show()
    {
        
        dp4::Select('id','nik','nama','kd_kec','kd_kel','tps')->where([['kd_kec','=','720304'],['kd_kel','=','7203042001']])->orderBy('id')->chunk(1000, function ($posts) {
            $xx = 0; 
            foreach ($posts as $post) {
                 $res = DataPenetapan::select('nik','nama','tps')
                        ->where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nik','=',$post->nik],['nama','=',$post->nama]]);
                 $data = $res->first();
                 if(!is_null($data)){
                     echo $post->id."-".$post->nama."=>"."$data->nama ditemukan di tps $data->tps<br>";
                     dp4::where('id','=',$post->id)->update(["tps_new"=>$data->tps]);
                     

                 }
            }
        });
        
    }
}
