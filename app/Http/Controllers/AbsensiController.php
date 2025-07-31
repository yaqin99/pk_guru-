<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedagogik;
use App\Models\Kepribadian;
use App\Models\Profesional;
use App\Models\NilaiAspek;
use App\Models\LokasiSekolah;
use App\Models\Mapel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{


    
    function hitungJarak($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000; // meter
    
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);
    
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
    
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    
        return $earthRadius * $angle;
    }

    public function hadir(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        $lokasiSekolah = LokasiSekolah::orderBy('created_at', 'desc')->first();

        // Hitung jarak

        // dd([
        //     'lokasiSekolah' => [
        //         'lat' => $lokasiSekolah->latitude,
        //         'lng' => $lokasiSekolah->longitude,
        //     ],
        //     'lokasiUser' => [
        //         'lat' => $request->lat,
        //         'lng' => $request->lng,
        //     ]
        // ]);
        $jarak = $this->hitungJarak(
            $lokasiSekolah->latitude,
            $lokasiSekolah->longitude,
            $request->lat,
            $request->lng
        );

        // if ($jarak > 20) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Anda di luar lokasi sekolah (' . round($jarak, 2) . ' m)'
        //     ], 403);
        // }

        $sudahAbsen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'status' => 'already',
                'message' => 'Anda sudah absen hari ini.'
            ]);
        }

        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'keterangan' => 'hadir'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil dicatat.'
        ]);
    }


    public function absensiGuru()
    {    
        $pages = 'absensi';
    
        $user = auth()->user();
        $bulanIni = now()->format('Y-m');
        $absensiData = Absensi::where('user_id', $user->id)
            ->where('tanggal', 'like', "$bulanIni%")
            ->pluck('keterangan', 'tanggal')
            ->toArray();
        return view('admin.pages.absensi.absensi', [
            'pages' => $pages,
            'absensi' => $absensiData // ⬅ ini yang penting!
        ]);
    }

    public function tambahManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan' => 'required|in:hadir,sakit,izin,alpha',
        ]);
    
        // Simpan ke database
        Absensi::create([
            'user_id' => $request->user_id,
            'keterangan' => $request->keterangan,
            'tanggal' => now()->toDateString(),
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil ditambahkan'
        ]);
    }

    public function index(Request $request)
    {
       
        $pages = 'guru' ; 
        $mapel = Mapel::all() ; 
        if ($request->ajax()) {

            $data = User::with('mapel')
            ->where('role', 1)
            ->orderBy('kelas', 'asc')
            ->orderBy('poin', 'desc') // Urutkan berdasarkan poin tertinggi
            ->orderBy('nama_user', 'asc')
            ->get();
        
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('kelas', function($row){
                    
                    if($row->kelas == 1){
                       return $kelas = 'Kelas 10';
                    } 
                    if($row->kelas == 2){
                        return $kelas = 'Kelas 11';
                    } 
                    else {
                        return $kelas = 'Kelas 12';
                    }
                     })
                    ->addColumn('mapel', function($row){
                    
                     return $row->mapel->nama_mapel ;
                     })
                    ->addColumn('poin', function($row){
                      return $row->poin;})
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
                            <a  onclick=\'viewGrafik(`'.$row.'`)\'
                            class="btn btn-info text-light btn-sm "
                            title="Lihat Grafik Performa"
                            style="cursor: pointer;">
                            <i class="bi bi-bar-chart-line"></i> 
                            </a>

 
                           <a onclick=\'viewAspek(`'.$row.'`)\' class="edit btn btn-primary text-light btn-sm ml-2" title="Lihat Aspek" style="cursor: pointer;">
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

        return view('admin.pages.guru' , [
            'pages' => $pages , 
            'mapels' => $mapel , 
        ]);
    }
}
