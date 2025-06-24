<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{

    public function profile($id){
        $user = User::find($id);
        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        try {
            $name =  request()->file('foto');
            $user = User::find($request->user_id);
            
            // Update data user kecuali username dan password
            $user->update([
                'nama_user' => $request->nama_user,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            // Jika ada file foto yang diupload
            if ($name != null) {

             
                $file = $request->file('foto');
                $fileName = $file->getClientOriginalName();
                
                // Cek dan hapus foto lama jika ada
                if ($user->foto && Storage::disk('public')->exists($user->nama_user.'/fotoProfil/'.$user->foto)) {
                    Storage::disk('public')->delete($user->nama_user.'/fotoProfil/'.$user->foto);
                }
                
                // Buat direktori jika belum ada
                if (!Storage::disk('public')->exists($user->nama_user.'/fotoProfil')) {
                    Storage::disk('public')->makeDirectory($user->nama_user.'/fotoProfil');
                }
                
                // Upload foto baru
                $file->storeAs($user->nama_user.'/fotoProfil', $fileName, 'public');
                
                // Update nama file foto di database
                $user->update([
                    'foto' => $fileName
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

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
                return redirect()->intended('/program')->with('success' , 'Selamat Datang Kembali');
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
