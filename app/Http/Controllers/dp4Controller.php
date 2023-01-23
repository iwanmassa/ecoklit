<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Dp4Import;
use App\Models\dp4;
use App\Models\DataPenetapan;
use App\Models\tps_tambahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
class dp4Controller extends Controller
{
    public function index(Request $request)
    {

     $level = Auth::user()->level;
     if(in_array($level,array('admin','operator'))){
        if($request->session()->has('kd_kec')){
           $kd_kec =  $request->session()->get('kd_kec');
           $kd_kel =  $request->session()->get('kd_kel');
           $tps =  $request->session()->get('tps');

           //summary penetapan 2019 
        }else{
            $first_kecamatan = DB::table('kecamatan')->select('kd_kec')->first();
            $kd_kec =  $first_kecamatan->kd_kec;
            $first_kel = DB::table('kel_des')->select('kd_kel_des')->where('kd_kec','=',$kd_kec)->first();
            $kd_kel =  $first_kel->kd_kel_des;
            $tps="ALL";
            $request->session()->put('kd_kec',$kd_kec);
            $request->session()->put('kd_kel',$kd_kel);
            
        }

        $kecamatan_data = DB::table('kecamatan')->get();
       }else{
        $kd_kec =  Auth::user()->kd_wilayah;
        if($request->session()->has('kd_kec')){
            $kd_kel =  $request->session()->get('kd_kel');
            $tps =  $request->session()->get('tps');
             //summary penetapan 2019 
         }else{
            $first_kel = DB::table('kel_des')->select('kd_kel_des')->where('kd_kec','=',$kd_kec)->first();
            $kd_kel =  $first_kel->kd_kel_des;
            $tps="ALL";
            $request->session()->put('kd_kec',$kd_kec);
            $request->session()->put('kd_kel',$kd_kel);
         }
         $kecamatan_data = NULL;
       }
        $sum_tps_2019 = DB::table('data_penetapan')
        ->select('tps', DB::raw('count(tps) as total'))
        ->where([['kd_kec','=',$kd_kec],['kd_kel','=',$kd_kel]])
        ->orderBy('tps')->groupBy('tps')->get();
        //summary dp4
        $sum_tps_2024 = DB::table('dp4')
        ->select('tps_new', DB::raw('count(tps_new) as total'))
        ->where([['kd_kec','=',$kd_kec],['kd_kel','=',$kd_kel]])
        ->orderBy('tps_new')->groupBy('tps_new')->get();
         
        $tps_nol_count = DB::table('dp4')->where([['kd_kec','=',$kd_kec],['kd_kel','=',$kd_kel],['tps_new','=','0']])->count();

        //init session
        $sesi_arr=['kd_kec'=>$kd_kec,
                        'kd_kel'=>$kd_kel,
                        'tps' =>$tps,
                        'tps_nol'=>$tps_nol_count];
        
                        

       // dd($request); 
        return view('dp4',['kecamatan_data'=>$kecamatan_data
                             ,'sum_tps_2019'=>$sum_tps_2019
                             ,'sum_tps_2024'=>$sum_tps_2024
                             ,'sesi'=>$sesi_arr                             
                            ]);
        
    }
    
    public function index2($kd_kec,$kel_data,$tps,Request $request)
    {
        $kecamatan_data = DB::table('kecamatan')->get();
        $sum_tps_2019 = DB::table('data_penetapan')
        ->select('tps', DB::raw('count(tps) as total'))
        ->where([['kd_kec','=',$request->get('kd_kec')],['kd_kel','=',$request->get('kd_kel')]])
        ->orderBy('tps')->groupBy('tps')->get();
        $sum_tps_2024 = DB::table('dp4')
        ->select('tps_new', DB::raw('count(tps_new) as total'))
        ->where([['kd_kec','=',$request->get('kd_kec')],['kd_kel','=',$request->get('kd_kel')]])
        ->orderBy('tps_new')->groupBy('tps_new')->get();

        if($request->has('kd_kec')){
            return view('dp4',['kecamatan_data'=>$kecamatan_data,'sum_tps_2019'=>$sum_tps_2019,'sum_tps_2024'=>$sum_tps_2024,'kd_kec'=>$request->input('kd_kec'),'kd_kel'=>$request->input('kd_kel'),'tps'=>$request->get('tps')]);
        }else{ 
        return view('dp4',['kecamatan_data'=>$kecamatan_data,'sum_tps_2019'=>$sum_tps_2019,'sum_tps_2024'=>$sum_tps_2024]);
        }
    }


    public function getKecamatan()
    {
        return DB::table('kecamatan')->get();
    }
    public function get_kel(Request $request)
    {
        $kel_data = DB::table('kel_des')->select('kd_kel_des','nama')->where('kd_kec','=',$request->input('kd_kec'))->get();  
        return $kel_data;
    }
    
    public function get_tps(Request $request)
    {
        //kalau sdh ada sesi
        if($request->session()->has('kec')){
        $kd_kec = $request->session()->get('kd_kec');
        $kd_kel = $request->session()->get('kd_kel'); 
        }else{
            $kd_kec = $request->get('kd_kec');
            $kd_kel = $request->get('kd_kel');
        }

        $tps_data = tps_tambahan::select('no_tps')->where([['kd_kec','=',$kd_kec],['kd_kel','=',$kd_kel]])->orderBy('no_tps')->get();  
        //$tps_data = dp4::select('tps_new')->where([['kd_kec','=','720304'],['kd_kel','=','7203042001']])->orderBy('tps_new')->groupBy('tps_new')->get();  
        return $tps_data;
    }
    public function get_tps_tambahan(Request $request)
    {
        //kalau sdh ada sesi
        if($request->session()->has('kec')){
        $kd_kec = $request->session()->get('kd_kec');
        $kd_kel = $request->session()->get('kd_kel'); 
        }else{
            $kd_kec = $request->get('kd_kec');
            $kd_kel = $request->get('kd_kel');
        }
        $tps_data = tps_tambahan::select('no_tps')->where([['kd_kec','=',$kd_kec],['kd_kel','=',$kd_kel]])->orderBy('no_tps')->get();  
        //$tps_data = dp4::select('tps_new')->where([['kd_kec','=','720304'],['kd_kel','=','7203042001']])->orderBy('tps_new')->groupBy('tps_new')->get();  
        return $tps_data;
    }

    public function json(Request $request)
    {
        $kd_kec = $request->session()->get('kd_kec');
        $kd_kel = $request->session()->get('kd_kel');
        $tps = $request->session()->get('tps');
         
        if(isset($kd_kec)){
            if(isset($tps) && $tps!="ALL"){
                $ret_data =  DataTables::of(Dp4::where([["kd_kec","=",$kd_kec],["kd_kel","=",$kd_kel],["tps_new","=",$tps]])->orderBy('nkk','asc'))->make(true);
            }else{
                $ret_data = DataTables::of(Dp4::where([["kd_kec","=",$kd_kec],["kd_kel","=",$kd_kel]])->limit(10))->make(true);
            }
        }else{
             $ret_data = DataTables::of(Dp4::where([["kd_kec","=",$request->input('kd_kec')]])->limit(10))->make(true);   
        }
        return $ret_data ;
    }

    public function set_filter_dp4(Request $request)
    {
        $request->session()->put('kd_kec',$request->get('kd_kec'));
        $kd_kel=$request->get('kd_kel'); 
        $tps=$request->get('tps'); 
        
        if(isset($kd_kel)){
            $request->session()->put('kd_kel',$request->get('kd_kel'));
        }

        if(isset($tps)){
            $request->session()->put('tps',$request->get('tps'));
        }
        
        return true;
    }    

    public function import(Request $request){
        $kd_kec = $request->post('kd_kec');
        $res = dp4::where("kd_kec","=",$kd_kec)->delete();
        //dd($request);
        $validatedData = $request->validate([

            'file' => 'required',
 
         ]);
        Excel::import(new Dp4Import,$request->file('file'));
            //return $request->all();
        return redirect('dp4')->with('status', $kd_kec.' Telah Selesai');
        
    }
    public function ganti_tps(Request $request)
    {
        //dd($request);
        
        if($request->has('nkk_set')){ 
          $kd_kec = $request->session()->get('kd_kec');
          $kd_kel = $request->session()->get('kd_kel'); 
          dp4::where([["nkk","=",$request->input('nkk_set')],["kd_kec",'=',$kd_kec],["kd_kel",'=',$kd_kel]])->update(['tps_new'=>$request->input('tps_new_ganti')]);
        }else{
          dp4::where("id","=",$request->input('id_pemilih'))->update(['tps_new'=>$request->input('tps_new_ganti')]); 
        }  
        return redirect('dp4')->with('status', 'Telah Selesai');
    }
    public function get_tps2019(Request $request)
    {
        dp4::Select('id','nik','nkk','nama','tempat_lahir','tgl_lahir','kd_kec','kd_kel','tps')->where([['kd_kec','=',$request->input('kd_kec')],['kd_kel','=',$request->input('kd_kel')]])->orderBy('id')->chunk(100, function ($posts) {
            $xx = 0; 
            foreach ($posts as $post) {
                //mencari berdasarkan NKK 
                $res = DataPenetapan::select('nik','nama','tps')->where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nkk','=',$post->nkk]]);
                $data = $res->first();
                if(!is_null($data)){
                    //echo $post->id."-".$post->nama."=>"."$data->nama ditemukan di tps $data->tps<br>";
                    dp4::where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nkk','=',$post->nkk]])->update(["tps_new"=>$data->tps]);
                }
                 //mencari berdasarkan NKK dan nama
                 $res = DataPenetapan::select('nik','nama','tps')->where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nkk','=',$post->nkk],['nama','=',$post->nama]]);
                 $data = $res->first();
                 if(!is_null($data)){
                     //echo $post->id."-".$post->nama."=>"."$data->nama ditemukan di tps $data->tps<br>";
                     dp4::where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nkk','=',$post->nkk]])->update(["tps_new"=>$data->tps]);
                 }
                 //mencari berdasarkan NIK
                 $res = DataPenetapan::select('nik','nama','tps')->where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nik','=',$post->nik]]);
                 $data = $res->first();
                 if(!is_null($data)){
                     //echo $post->id."-".$post->nama."=>"."$data->nama ditemukan di tps $data->tps<br>";
                     dp4::where('id','=',$post->id)->update(["tps_new"=>$data->tps]);
                     dp4::where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nkk','=',$post->nkk]])->update(["tps_new"=>$data->tps]);
                 }
                 
                //mencari berdasarkan nama dan ttl dan tgl_lahir
                $res = DataPenetapan::select('nik','nama','tps')->where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nama','=',$post->nama],['tempat_lahir','=',$post->nama],['tgl_lahir','=',$post->tgl_lahir]]);
                $data = $res->first();
                if(!is_null($data)){
                    //echo $post->id."-".$post->nama."=>"."$data->nama ditemukan di tps $data->tps<br>";
                    dp4::where('id','=',$post->id)->update(["tps_new"=>$data->tps]);
                    dp4::where([['kd_kec','=',$post->kd_kec],['kd_kel','=',$post->kd_kel],['nkk','=',$post->nkk]])->update(["tps_new"=>$data->tps]);
                }
                

                 
            }
        });
        
        return json_encode(array('sukses'=>true,"pesan"=>"sukses"));

    }

    public function tambah_tps(Request $request)
    {
        
    }

}
