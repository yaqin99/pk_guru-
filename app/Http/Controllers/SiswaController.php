<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\mapel;
use App\Models\User;
use App\Models\Komponen;
use App\Models\RincianNilaiAspek;
use App\Http\Controllers\Controller;
use App\Models\NilaiAspek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
    
        // 1. Cek apakah siswa ini sudah pernah menilai guru ini untuk tipe aspek ini
        $sudahDinilai = RincianNilaiAspek::where('siswa_id', $siswa_id)
            ->where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->exists();
    
        if ($sudahDinilai) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah menilai guru ini pada tipe aspek tersebut.',
                'status' => 'already_rated'
            ]);
        }
    
        // 2. Simpan data penilaian baru
        foreach ($penilaians as $penilaian) {
            RincianNilaiAspek::create([
                'siswa_id' => $siswa_id,
                'guru_id' => $guru_id,
                'tipe_aspek' => $penilaian['tipe_aspek'],
                'komponen_id' => $penilaian['id_komponen'],
                'tanggal' => Carbon::now(),
                'nilai' => $penilaian['nilai'],
            ]);
        }
    
        // 3. Hitung total siswa yang sudah menilai guru ini untuk tipe ini
        $totalSiswaSudahMenilai = RincianNilaiAspek::where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->distinct('siswa_id')
            ->count('siswa_id');
    
        // 4. Total siswa tetap 20 (manual)
        $totalSiswa = 20;
    
        // 5. Lanjutkan perhitungan skor
        $totalNilai = RincianNilaiAspek::where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->sum('nilai');
    
        $jumlahKomponen = RincianNilaiAspek::where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->distinct('komponen_id')
            ->count('komponen_id');
    
        $skorMaksimal = $totalSiswa * $jumlahKomponen * 2;
        $persentase = ($totalNilai / $skorMaksimal) * 100;
    
        if ($persentase >= 81) {
            $keterangan = 'Baik';
        } elseif ($persentase >= 61) {
            $keterangan = 'Cukup';
        } else {
            $keterangan = 'Kurang';
        }
    
        // 6. Cek apakah sudah ada data NilaiAspek sebelumnya
        $existing = NilaiAspek::where('user_id', $guru_id)
            ->where('tipe', $tipe)
            ->first();
    
        if ($existing) {
            // Update: Gabungkan skor lama dan baru (ambil rata-rata atau dijumlah tergantung kebutuhan)
            // Misalnya: Update dengan skor terakhir (replace)
            $existing->update([
                'tanggal' => Carbon::now(),
                'skor' => round($persentase, 2),
                'keterangan' => $keterangan,
            ]);
        } else {
            // Create jika belum ada
            NilaiAspek::create([
                'user_id' => $guru_id,
                'tanggal' => Carbon::now(),
                'tipe' => $tipe,
                'skor' => round($persentase, 2),
                'keterangan' => $keterangan,
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
