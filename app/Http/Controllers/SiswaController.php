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
use App\Services\WhatsAppService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{

    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
    
    
    public function index(Request $request)
    {
       
        $pages = 'siswa' ; 
        if ($request->ajax()) {

            $data = Siswa::orderBy('kelas', 'asc')
            ->orderBy('no_absen', 'asc') // Urutkan berdasarkan poin tertinggi
            ->orderBy('nama_siswa', 'asc')
            ->get();
        
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                   
                    ->addColumn('action', function($row){
                        if(Auth::user()->role == 3 ){
                            $btn = '
                            <div class="btn-group">
                            <a onclick=\'viewAspek(`'.$row.'`)\' class="edit btn btn-primary text-light btn-sm" title="Lihat Aspek" style="cursor: pointer;">
                            <i class="bi bi-eye-fill" ></i>
                            </a>
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                        } else {

                        
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'viewAspek(`'.$row.'`)\' class="edit btn btn-primary text-light btn-sm" title="Lihat Aspek" style="cursor: pointer;">
                           <i class="bi bi-eye-fill" ></i>
                           </a>
                           <a onclick=\'editGuru(`'.$row.'`)\' class="edit btn btn-warning text-light btn-sm ml-2" title="Edit Data" style="cursor: pointer;">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           <a href="javascript:void(0)" onclick=\'deleteGuru(`'.$row['id'].'`)\' class="ml-2 edit btn btn-danger text-light btn-sm" title="Hapus Data" style="cursor: pointer;"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                        }
                      

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.siswa' , [
            'pages' => $pages , 
        ]);
    }


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
    
        // 1. Cek apakah siswa sudah menilai guru ini untuk tipe aspek ini
        $sudahDinilai = RincianNilaiAspek::where('siswa_id', $siswa_id)
            ->where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->whereYear('tanggal', Carbon::now()->year)
            ->exists();
    
        if ($sudahDinilai) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah menilai guru ini pada tipe aspek tersebut untuk tahun ini.',
                'status' => 'already_rated'
            ]);
        }
    
        // 2. Simpan penilaian baru
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
    
        // 3. Hitung jumlah siswa yang sudah menilai (tahun berjalan)
        $jumlahSiswaMenilai = RincianNilaiAspek::where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->whereYear('tanggal', Carbon::now()->year)
            ->distinct('siswa_id')
            ->count('siswa_id');
    
        // 4. Hitung total nilai dan jumlah komponen (tahun berjalan)
        $totalNilai = RincianNilaiAspek::where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('nilai');
    
        $jumlahKomponen = RincianNilaiAspek::where('guru_id', $guru_id)
            ->where('tipe_aspek', $tipe)
            ->whereYear('tanggal', Carbon::now()->year)
            ->distinct('komponen_id')
            ->count('komponen_id');
    
        $skorMaksimal = $jumlahSiswaMenilai * $jumlahKomponen * 2;
        $persentase = ($skorMaksimal > 0) ? ($totalNilai / $skorMaksimal) * 100 : 0;
    
        if ($persentase >= 90) {
            $keterangan = 'Sangat Baik';
        } elseif ($persentase >= 80) {
            $keterangan = 'Baik';
        } elseif ($persentase >= 70) {
            $keterangan = 'Cukup';
        } elseif ($persentase >= 60) {
            $keterangan = 'Kurang';
        } else {
            $keterangan = 'Sangat Kurang';
        }
    
        // 5. Cek apakah sudah ada NilaiAspek tahun ini
        $tahunSekarang = Carbon::now()->year;
    
        $existing = NilaiAspek::where('user_id', $guru_id)
            ->where('tipe', $tipe)
            ->whereYear('tanggal', $tahunSekarang)
            ->first();
    
        if ($existing) {
            // Update data tahun ini
            $existing->update([
                'tanggal' => Carbon::now(),
                'jumlah_siswa' => $jumlahSiswaMenilai,
                'skor' => round($persentase, 2),
                'keterangan' => $keterangan,
            ]);
        } else {
            // Buat record baru untuk tahun ini
            NilaiAspek::create([
                'user_id' => $guru_id,
                'tanggal' => Carbon::now(),
                'tipe' => $tipe,
                'jumlah_siswa' => $jumlahSiswaMenilai,
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
