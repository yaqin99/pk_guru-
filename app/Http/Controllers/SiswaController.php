<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\mapel;
use App\Models\User;
use App\Models\Komponen;
use App\Models\RincianNilaiAspek;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function penilaian(){
        $siswa = Siswa::all();
        $komponen = Komponen::all();
        $mapel = Mapel::all();

        $guru = User::where('role' , 1)->get();
        return view('penilaian.penilaian' , [
            'siswas' => $siswa , 
            'gurus' => $guru , 
            'komponens' => $komponen , 
            'mapels' => $mapel , 

        ]);
    }


    public function getKomponen(){
       $data = Komponen::where('tipe', request('tipe'))->get();
        return response()->json($data);
            }

    public function openPenilaian(Request $request)
    {
        $siswa = Siswa::where('id', $request->siswa)->first();
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan']);
        }
    
        // Validasi password (asumsi password disimpan plain text; jika hash sesuaikan dengan Hash::check)
        if (!Hash::check($request->password, $siswa->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah']);
        }
    
        return response()->json([
            'success' => true, 
            'message' => 'Akses diterima',
            'siswa_id' => $siswa->id,
            'guru_id' => $request->guru , 
        ]);
    }

    public function penilaianMethod(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $guru_id = $request->guru_id;
        $penilaians = $request->penilaian;
        $tipe = $request->tipe_aspek;
    
        foreach ($penilaians as $penilaian) {
            RincianNilaiAspek::create([
                'siswa_id' => $siswa_id,
                'guru_id' => $guru_id,
                'tipe_aspek' => $penilaian['tipe_aspek'],
                'komponen_id' => $penilaian['id_komponen'], // ✅ simpan ID komponen
                'tanggal' => Carbon::now(),
                'nilai' => $penilaian['nilai'],
            ]);
        }
    
        return response()->json(['success' => true]);
    }
    


public function getGuruByMapelKelas(Request $request)
{
    $gurus = User::where('role', 1)
        ->where('mapel_id', $request->mapel_id)
        ->where('kelas', $request->kelas)
        ->select('id', 'nama_user')
        ->orderBy('nama_user')
        ->get();

    return response()->json($gurus);
}

public function cekPenilaianAspek(Request $request)
{
    $sudahDinilai = RincianNilaiAspek::where('siswa_id', $request->siswa_id)
        ->where('guru_id', $request->guru_id)
        ->where('tipe_aspek', $request->tipe_aspek)
        ->exists();

    return response()->json(['sudahDinilai' => $sudahDinilai]);
}



}
