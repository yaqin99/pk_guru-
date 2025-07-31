<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function getGrafikKemajuan(Request $request)
    {
        $tahun = $request->tahun;
    
        // === Jumlah siswa per tahun ===
        $siswaQuery = DB::table('siswas');
        if ($tahun && $tahun !== 'all') {
            $siswaQuery->where('angkatan', $tahun);
        }
        $siswa = $siswaQuery
            ->selectRaw('angkatan as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('total', 'tahun');
    
        // === Jumlah guru per tahun ===
        $guruQuery = DB::table('users')->where('role', 1);
        if ($tahun && $tahun !== 'all') {
            $guruQuery->whereYear('tanggal', $tahun);
        }
        $guru = $guruQuery
            ->selectRaw('YEAR(tanggal) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('total', 'tahun');
    
        // === Status guru ===
        $statusGuruQuery = DB::table('users')->where('role', 1);
        if ($tahun && $tahun !== 'all') {
            $statusGuruQuery->whereYear('tanggal', $tahun);
        }
        $statusGuru = $statusGuruQuery
            ->select('status_kepegawaian', DB::raw('COUNT(*) as total'))
            ->groupBy('status_kepegawaian')
            ->pluck('total', 'status_kepegawaian');
    
        // === Rata-rata usia guru per tahun ===
        $usiaGuruQuery = DB::table('users')
            ->where('role', 1)
            ->whereNotNull('tanggal_lahir');
    
        if ($tahun && $tahun !== 'all') {
            $usiaGuruQuery->whereYear('tanggal', $tahun);
        }
    
        $usiaGuru = $usiaGuruQuery
            ->selectRaw('YEAR(tanggal) as tahun, ROUND(AVG(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())), 1) as rata_usia')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('rata_usia', 'tahun');
    
        // === Return JSON ke frontend ===
        return response()->json([
            'siswa_per_tahun' => [
                'labels' => $siswa->keys(),
                'data'   => $siswa->values()
            ],
            'guru_per_tahun' => [
                'labels' => $guru->keys(),
                'data'   => $guru->values()
            ],
            'status_guru' => $statusGuru,
            'usia_guru' => [
                'labels' => $usiaGuru->keys(),
                'data'   => $usiaGuru->values()
            ]
        ]);
    }
    
    
    

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
