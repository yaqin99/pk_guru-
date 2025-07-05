<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Mapel;
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
use Illuminate\Support\Str;

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
             ->orderBy('no_absen', 'asc')
             ->get();

        
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                    
                        if($row->status == 1){
                           return $kelas = 'Aktif';
                        } 
                       
                        else {
                            return $kelas = 'Non Aktif';
                        }
                         })
                    ->addColumn('action', function($row){
                        if(Auth::user()->role == 3 ){
                            $btn = '
                           
                            
                            
                            
                            ';
                            
     
                             return $btn;
                        } else {

                        
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'ubahStatus(`'.$row['id'].'`)\' class="edit btn btn-primary text-light btn-sm" title="Edit Status Siswa" style="cursor: pointer;">
                           <i class="bi bi-ban-fill"></i>
                           </a>
                           <a onclick=\'editSiswa(`'.$row.'`)\' class="edit btn btn-warning text-light btn-sm ml-2" title="Edit Data" style="cursor: pointer;">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           <a href="javascript:void(0)" onclick=\'deleteSiswa(`'.$row['id'].'`)\' class="ml-2 edit btn btn-danger text-light btn-sm" title="Hapus Data" style="cursor: pointer;"><i class="bi bi-trash3-fill"></i></a>
                           
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

    public function cekAbsenTerakhir(Request $request)
{
    $kelas = $request->kelas;

    // Ambil no_absen tertinggi dari kelas yang dipilih
    $lastAbsen = Siswa::where('kelas', $kelas)
                      ->max('no_absen');

    $absenBerikutnya = $lastAbsen ? $lastAbsen + 1 : 1;

    return response()->json([
        'no_absen_berikutnya' => $absenBerikutnya
    ]);
}

public function addSiswa(Request $request)
{
    $request->validate([
        'nama_siswa' => 'required|string|max:255',
        'kelas' => 'required|string',
        'no_absen' => 'required|integer',
        'no_hp' => 'nullable|string|max:20',
        'angkatan' => 'required|integer',
    ]);

    
    if ($request->id_siswa) {
        // Edit mode
        $siswa = Siswa::find($request->id_siswa);
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan!']);
        }
    
        $siswa->update([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'no_absen' => $request->no_absen,
            'no_hp' => $request->no_hp,
            'angkatan' => $request->angkatan,
        ]);
    
    } else {
        // Tambah mode pakai create()
        Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'no_absen' => $request->no_absen,
            'no_hp' => $request->no_hp,
            'angkatan' => $request->angkatan,
            'status' => 1,
            'password' => bcrypt(12345),
        ]);
    }
    
    return response()->json(['success' => true, 'message' => 'Data siswa berhasil disimpan!']);
}

public function deleteSiswa($id)
{
  $deltete = Siswa::find($id)->delete();
}

public function getSiswa($id)
{
    $siswa = Siswa::find($id);

    if (!$siswa) {
        return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan'], 404);
    }

    return response()->json(['success' => true, 'data' => $siswa]);
}



    public function penilaian(){
        $siswa = Siswa::where('status' , 1)->get();
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


public function ubahStatus(Request $request)
{
    $siswa = Siswa::find($request->id);

    if (!$siswa) {
        return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan.']);
    }

    // Toggle status
    $siswa->status = $siswa->status == 1 ? 0 : 1;
    $siswa->save();

    $statusText = $siswa->status == 1 ? 'diaktifkan' : 'dinonaktifkan';

    return response()->json(['success' => true, 'message' => "Siswa berhasil $statusText."]);
}


public function kirimWaSemua(Request $request)
{
    $siswaAktif = Siswa::where('status', 1)->whereNotNull('no_hp')->get();

    if ($siswaAktif->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Tidak ada siswa aktif yang memiliki nomor HP.']);
    }

    foreach ($siswaAktif as $siswa) {
        // 1. Generate password random (6 karakter)
        $plainPassword = Str::random(6);

        // 2. Simpan password terenkripsi ke database
        $siswa->password = Hash::make($plainPassword);
        $siswa->save();

        // 3. Format nomor WA
        $no_hp = $this->formatNomorWa($siswa->no_hp);

        // 4. Pesan dikirim ke WA
        $message = "Assalamu'alaikum, berikut adalah informasi akun Anda:\n".
                   "Nama: *{$siswa->nama_siswa}*\n".
                   "Kelas: *{$siswa->kelas}*\n".
                   "Password: *{$plainPassword}*\n\n".
                   "Gunakan password ini untuk Mengisi Survey Aspek Guru. Jangan dibagikan ke orang lain!\nTerima kasih 🙏";

        // 5. Kirim via WhatsApp
        $this->whatsappService->sendMessage($no_hp, $message);
    }

    return response()->json(['success' => true, 'message' => 'Password dan pesan berhasil dikirim ke semua siswa aktif.']);
}

private function formatNomorWa($noHp)
{
    $nomor = preg_replace('/[^0-9]/', '', $noHp);
    if (substr($nomor, 0, 1) == '0') {
        $nomor = '62' . substr($nomor, 1);
    }
    return $nomor;
}




}
