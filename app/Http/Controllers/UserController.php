<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(){
        return view('admin.authentication.login');
    }

    public function logOut(Request $req){
        Auth::guard('web')->logout();
        //$request dan request() itu sama aja 
    $req->session()->invalidate();
 
    $req->session()->regenerateToken();
 
    return redirect('/login');
     }

     
    public function loginMethod(Request $req){

        $req->validate([
            'username' => 'required' , 
            'password' => 'required' , 
        ]); 
        if (Auth::guard('web')->attempt(['username' => $req->username , 'password' => $req->password] , $req->remember)) {
            $req->session()->regenerate();
            $user = Auth::user();
            if ($user->role == 1) {
                return redirect()->intended('/pengajuan')->with('success' , 'Selamat Datang Kembali');
            } else if ($user->role == 2) {
                return redirect()->intended('/pengajuan')->with('success' , 'Selamat Datang Kembali');
            } else if ($user->role == 3) {
                return redirect()->intended('/pengajuan')->with('success' , 'Selamat Datang Kembali');
            }
        } else {
            return back()->with('gagal' , 'Login Gagal');
        }

        if (Auth::viaRemember()) {

            $req->session()->regenerate();

            return redirect()->intended('/admin');
        }

        
    }
}
