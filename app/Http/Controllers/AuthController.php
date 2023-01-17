<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('login');
    }

    public function authxx(Request $request)
    {
        $validasi = $request->validate([
            'email'=>['required'],
            'password'=>['required']
        ]);

        if(Auth::attempt($validasi)){
            if(Auth::user()->aktif==0){
                Session::flash('status','Gagal Login');
                Session::flash('message','Akun Sudah Tidak Aktif, Silahkan Hubungi Admin KPU Donggala');
                return redirect('/login');    
            }else{
                $request->session()->regenerate();
                return redirect('dp4');
            }

            
        }else{
            Session::flash('status','Gagal Login');
            Session::flash('message','Akun Belum Terdaftar, Silahkan Hubungi Admin KPU Donggala');
            return redirect('/login');
        }    
    }

    public function logout(Request $request )
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }
}
