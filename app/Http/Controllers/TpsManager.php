<?php

namespace App\Http\Controllers;

use App\Models\dp4;
use App\Models\kecamatan;
use App\Models\kel_des;
use App\Models\tps_tambahan;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class TpsManager extends Controller
{
    public function index(Request $request)
    {
        $kec = kecamatan::orderBy('kd_kec')->get();
        
        foreach($kec as $item_kec){
          $kel = kel_des::where('kd_kec','=','720304')->get();
          echo($item_kec->kd_kec)."<br>";
        }  
        

        $kel_tps = Array();
        foreach($kel as $item){
          //  echo $item->nama."<br>";
            $tps_set = tps_tambahan::select('id','no_tps','sts')
                    ->where([['kd_kel','=',$item->kd_kel_des]])
                    ->get();
           $kel_tps[] = array('nama'=>$item->nama,'kel_des'=>$item->kd_kel_des,'tps'=>$tps_set);
           
        }  
        //var_dump($kel_tps);        
      // return view('tps_manager',['kel_tps'=>$kel_tps]);
    }
}
