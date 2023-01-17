<?php

namespace App\Http\Controllers;

use App\Imports\DataPenetapanImport;
use App\Models\DataPenetapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class DataPenetapanController extends Controller
{
    public function import(Request $request)
    {
        
         
        $kd_kec = $request->post('kd_kec');
        $kd_kel = $request->post('kd_kel');
        //dd($request->post('kd_kec'));
        $res = DataPenetapan::where([["kd_kec","=",$kd_kec],["kd_kel","=",$kd_kel]])->delete();
        $validatedData = $request->validate([

            'file' => 'required',
 
         ]);
        Excel::import(new DataPenetapanImport,$request->file('file'));
            //return $request->all();
        return redirect()->route('penetapan',['kd_kec'=>$kd_kec,'kd_kel'=>$kd_kel]);
        
    }

    public function json(Request $request)
    {   
        //dd($request); 
        if(!empty(request()->get('kd_kec'))){
        return DataTables::of(DataPenetapan::where([["kd_kec","=",request()->get('kd_kec')],["kd_kel","=",request()->get('kd_kel')]])->limit(10))->make(true);
        }else{
        return DataTables::of(DataPenetapan::limit(10))->make(true);            
        }
    }
    public function get_kecamatan()
    {
        $kecamatan_data = DB::table('kecamatan')->select('kd_kec','nama')->get();  
        return $kecamatan_data;
    }
    public function get_kel(Request $request)
    {
        $kel_data = DB::table('kel_des')->select('kd_kel_des','nama')->where('kd_kec','=',$request->input('kd_kec'))->get();  
        return $kel_data;
    }

    public function index(Request $request)
    {
        
        $kecamatan_data = DB::table('kecamatan')->get();
        if($request->has('kd_kec')){
            return view('penetapan',['kecamatan_data'=>$kecamatan_data,'kd_kec'=>$request->input('kd_kec'),'kd_kel'=>$request->input('kd_kel')]);
        }else{ 
        return view('penetapan',['kecamatan_data'=>$kecamatan_data]);
        }
    }
}
