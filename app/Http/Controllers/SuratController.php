<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use App\Models\Aspek;
use App\Models\Pengajuan;
use App\Models\Pedagogik;
use App\Models\Kepribadian;
use App\Models\Profesional;
use App\Models\Sosial;
use App\Models\NilaiAspek;
use Carbon\Carbon;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsAppService;


class SuratController extends Controller
{

  
  protected $whatsappService;

  public function __construct(WhatsAppService $whatsappService)
  {
      $this->whatsappService = $whatsappService;
  }
  
  public function sendWhatsApp()
  {
      $phone   = '08999920375'; // Nomor tujuan
      $message = 'Halo, ini pesan otomatis dari Laravel 10 menggunakan Fonnte!';

      $response = $this->whatsappService->sendMessage($phone, $message);

      return response()->json($response);
  }


    public function index(Request $request)
    {
        $pages = 'surat' ; 
        
        $guru = User::select('nama_user' , 'id')->where('role' , 1)->get();
        if ($request->ajax()) {
          if (Auth::user()->role == 1) {
            $data = Surat::with(['user' , 'aspek'])
                        ->join('aspeks', 'surat_kinerjas.id', '=', 'aspeks.surat_kinerja_id')
                        ->where('user_id' , Auth::user()->id)
                        ->orderBy('surat_kinerjas.tanggal', 'desc')
                        ->orderBy('surat_kinerjas.created_at', direction: 'desc')
                        ->get();
          } 
          else if (Auth::user()->role == 3) {
            $data = Surat::with(['user' , 'aspek'])
                        ->join('aspeks', 'surat_kinerjas.id', '=', 'aspeks.surat_kinerja_id')
                        ->orderBy('surat_kinerjas.tanggal', 'desc')
                        ->orderBy('surat_kinerjas.created_at', direction: 'desc')
                        ->get();
           
          } else {
            $data = Surat::with(['user' , 'aspek'])
                        ->join('aspeks', 'surat_kinerjas.id', '=', 'aspeks.surat_kinerja_id')
                        ->orderBy('surat_kinerjas.tanggal', 'desc')
                        ->orderBy('surat_kinerjas.created_at', direction: 'desc')
                        ->get();
          }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->user->nama_user;})
                    ->addColumn('nama_surat', function($row){
                    return $row->nama_surat;})
                    ->addColumn('tipe', function($row){
                    return $row->tipe == 1 ? 'Surat Kinerja' : 'Surat Teguran';})
                    ->addColumn('tanggal', function($row){
                    return $row->tanggal;})
                    
                    ->addColumn('action', function($row){
                      if (Auth::user()->role == 3) {
                        $btn = '
                        <div class="btn-group">
                        <a onclick=\'cetakSurat(`'.$row.'`)\' class="ml-2 edit btn btn-primary btn-sm text-light" >
                        <i class="bi bi-printer-fill" ></i>
                        </a>
                        
                        <a onclick=\'editSurat(`'.$row.'`)\' class="ml-2 edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editSurat">
                        <i class="bi bi-pencil-fill" ></i>
                        </a>
                        
                        <a href="javascript:void(0)" onclick=\'deleteSurat(`'.$row->id.'`)\' class="ml-2 edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                        
                        </div>
                        
                        ';
                        
 
                         return $btn;
                      }
                      if (Auth::user()->role == 1) {
                        $btn = '
                        <div class="btn-group">
                        <a onclick=\'cetakSurat(`'.$row.'`)\' class="edit btn btn-primary btn-sm text-light" >
                        <i class="bi bi-printer-fill" ></i>
                        </a>
                        </div>
                        
                        ';
                        
 
                         return $btn;
                      } if (Auth::user()->role == 2) {

                        if ($row->status == 2 || $row->status == 4) {
                          $btn = '
                          <div class="btn-group">
                            <a onclick=\'cetakSurat(`'.$row.'`)\' class="ml-2 edit btn btn-primary btn-sm text-light" >
                            <i class="bi bi-printer-fill" ></i>
                            </a>
                          </div>
                          
                          ';
                          return $btn;
                        } 
                         else {
                        //   $btn = '
                        // <div class="btn-group">
                        // <a onclick=\'cetakSurat(`'.$row.'`)\' class="ml-2 edit btn btn-primary btn-sm text-light" >
                        // <i class="bi bi-printer-fill" ></i>
                        // </a>
                        // <a onclick=\'suratAspek(`'.$row->id.'`)\' class="ml-2 edit btn btn-success btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editAspek">
                        // <i class="bi bi-file-earmark-bar-graph" ></i>
                        // </a>
                        // <a onclick=\'editSurat(`'.$row.'`)\' class="ml-2 edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editSurat">
                        // <i class="bi bi-pencil-fill" ></i>
                        // </a>
                        
                        // <a href="javascript:void(0)" onclick=\'deleteSurat(`'.$row->id.'`)\' class="ml-2 edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                        
                        // </div>
                        
                        // ';
                        
                          $btn = '
                        <div class="btn-group">
                        <a onclick=\'cetakSurat(`'.$row.'`)\' class="ml-2 edit btn btn-primary btn-sm text-light" >
                        <i class="bi bi-printer-fill" ></i>
                        </a>
                        
                        <a onclick=\'editSurat(`'.$row.'`)\' class="ml-2 edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editSurat">
                        <i class="bi bi-pencil-fill" ></i>
                        </a>
                        
                        <a href="javascript:void(0)" onclick=\'deleteSurat(`'.$row->id.'`)\' class="ml-2 edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                        
                        </div>
                        
                        ';
                        
 
                         return $btn;
                         }
                      
                      }
                           
                    })
                    ->rawColumns(['status','action','penerusan'])
                    ->make(true);
        }

        return view('admin.pages.surat' , [
            'pages' => $pages , 
            'gurus' => $guru, 
        ]);
    }
    public function editSurat(Request $request)
    {
        
        $add = Surat::where('id', $request->id)->update([
            'user_id' => request('nama_user'), 
            'nama_surat' => request('nama_surat_edit'), 
            'tipe' => request('tipe_surat'),
            'tanggal' => request('tanggal'), 
            'keterangan' => request('keterangan'), 
          ]);

          $no_guru = User::find($request->nama_user)->no_hp;


            $message_guru = "Surat Kinerja Anda Telah diperbaiki oleh Kepala Sekolah". 
            "\nSilahkan cek dan cetak cetak surat pada aplikasi PK Guru".
            "\nTerima Kasih";


        $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);
        
    }
    public function teruskanSurat(Request $request)
    {
      $no_kepsek = User::where('role' , 3)->first();

      $data = Surat::where('id', $request->id)->update([
        'status' => 2, 
      ]);

      $message_kepsek = "Ada surat yang menunggu persetujuan dari Anda". 
          "\nMohon untuk segera diperiksa".
          "\nTerima Kasih";

      $response_kepsek = $this->whatsappService->sendMessage($no_kepsek->no_hp, $message_kepsek);
      return response()->json(['message' => 'success']);
    }
    public function approve(Request $request)
    {
        $surat = Surat::where('id' , $request->id)->first();
        $no_guru = User::find($surat->user_id)->no_hp;
        $add = Surat::where('id', $request->id)->update([
            'status' => 4, 
            
          ]);

        $message_guru = "Surat anda telah disetujui oleh Kepala Sekolah". 
                   "\nSilahkan melakukan cetak surat di akun anda".
                   "\nTerima Kasih";

        
        $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);
        
    }
    public function tolak(Request $request)
    {
      $no_admin = User::where('role' , 2)->first();

      $data = Surat::where('id', $request->id)->update([
        'status' => 3, 
      ]);

      $message_admin = "Surat anda telah ditolak oleh Admin". 
      "\nSilahkan melakukan perbaikan surat di akun anda".
      "\nTerima Kasih";

     $response_kepsek = $this->whatsappService->sendMessage($no_admin->no_hp, $message_admin);
      return response()->json(['message' => 'success']);
    }
    public function cekGuru(Request $request)
    {
        $guruId = $request->input('id');
        $tahun = $request->input('tahun');
    
        $aspekStatus = [
            'pedagogik' => [
                'ada' => false,
                'nilai_kosong' => false,
            ],
            'kepribadian' => [
                'ada' => false,
                'nilai_kosong' => false,
            ],
            'profesional' => [
                'ada' => false,
                'nilai_kosong' => false,
            ],
            'sosial' => [
                'ada' => false,
                'nilai_kosong' => false,
            ],
        ];
    
        // PEDAGOGIK
        $pedagogik = Pedagogik::where('user_id', $guruId)->whereYear('tanggal', $tahun)->get();
        if ($pedagogik->count() > 0) {
            $aspekStatus['pedagogik']['ada'] = true;
            $aspekStatus['pedagogik']['nilai_kosong'] = $pedagogik->contains(fn($item) => $item->nilai === null || $item->nilai === '' || $item->nilai === 0);
        }
    
        // KEPRIBADIAN
        $kepribadian = Kepribadian::where('user_id', $guruId)->whereYear('tanggal', $tahun)->get();
        if ($kepribadian->count() > 0) {
            $aspekStatus['kepribadian']['ada'] = true;
            $aspekStatus['kepribadian']['nilai_kosong'] = $kepribadian->contains(fn($item) => $item->nilai === null || $item->nilai === '' || $item->nilai === 0);
        }
    
        // PROFESIONAL
        $profesional = Profesional::where('user_id', $guruId)->whereYear('tanggal', $tahun)->get();
        if ($profesional->count() > 0) {
            $aspekStatus['profesional']['ada'] = true;
            $aspekStatus['profesional']['nilai_kosong'] = $profesional->contains(fn($item) => $item->nilai === null || $item->nilai === '' || $item->nilai === 0);
        }
    
        // SOSIAL
        $sosial = Sosial::where('user_id', $guruId)->whereYear('tanggal', $tahun)->get();
        if ($sosial->count() > 0) {
            $aspekStatus['sosial']['ada'] = true;
            $aspekStatus['sosial']['nilai_kosong'] = $sosial->contains(fn($item) => $item->nilai === null || $item->nilai === '' || $item->nilai === 0);
        }
    
        // Cek aspek yang belum ada dan nilai yang kosong
        $aspekKosong = [];
        $nilaiKosong = [];
    
        foreach ($aspekStatus as $aspek => $status) {
            if (!$status['ada']) {
                $aspekKosong[] = ucfirst($aspek);
            } elseif ($status['nilai_kosong']) {
                $nilaiKosong[] = ucfirst($aspek);
            }
        }
    
        $isLengkap = count($aspekKosong) === 0 && count($nilaiKosong) === 0;
    
        return response()->json([
            'message' => 'success',
            'lengkap' => $isLengkap,
            'aspek_kosong' => $aspekKosong,
            'nilai_kosong' => $nilaiKosong,
        ]);
    }
    



    public function addSurat(Request $request)
    {
        
        if(request('tipe_surat') == 1){
          if (request('keterangan') == ''){
            $keterangan = 'telah melaksanakan program kegiatan yang diajukan dengan baik sesuai dengan kurikulum yang berlaku dan memiliki kinerja yang baik';
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Kinerja'.' '.date("Y"), 
              'tipe' => request('tipe_surat'),
              'tanggal' => request('tanggal'), 
              'keterangan' => $keterangan, 
              'status' => 4,
            ]);
          } else {
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Kinerja'.' '.date("Y"), 
              'tipe' => request('tipe_surat'),
              'tanggal' => request('tanggal'), 
              'keterangan' => request('keterangan'), 
              'status' => 4,
            ]);
          }
              $no_guru = User::find($request->nama_user)->no_hp;
              Aspek::create([
                'surat_kinerja_id' => $add->id  , 
                'pedagogik' => null, 
                'kepribadian' => null, 
                'profesional' => null,
                'sosial' => null, 
              ]);

              $message_guru = "Surat Kinerja Anda Telah dikeluarkan oleh Kepala Sekolah". 
              "\nSilahkan cetak surat pada aplikasi PK Guru".
              "\nTerima Kasih";
    
    
            $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);


        } else {


          if (request('keterangan') == ''){
            $keterangan = 'telah melaksanakan program kegiatan yang diajukan dengan baik sesuai dengan kurikulum yang berlaku dan memiliki kinerja yang baik';
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Teguran'.' '.date("Y"), 
              'tipe' => request('tipe_surat'),
              'tanggal' => request('tanggal'), 
              'keterangan' => $keterangan, 
              'status' => 1,
            ]);
          } else {
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Teguran'.' '.date("Y"), 
              'tipe' => request('tipe_surat'),
              'tanggal' => request('tanggal'), 
              'keterangan' => request('keterangan'), 
              'status' => 1,
            ]);
          }


           

              Aspek::create([
                'surat_kinerja_id' => $add->id  , 
                'pedagogik' => null, 
                'kepribadian' => null, 
                'profesional' => null,
                'sosial' => null, 
              ]);
        }
        
       
          
        
    }
    
    /**
     * Display the specified resource.
     */
    public function deleteSurat($id)
    {
      $data = Surat::find($id);
      Surat::where('id' , $id)->delete();
      Aspek::where('surat_kinerja_id' , $id)->delete();
    }

    public function suratKinerja(){
      $pages = 'suratKinerja' ; 
      return view('admin.pages.cetak.suratKinerja' , [
        'pages' => $pages , 
      ]);
    }

    public function cetak()
{
    try {
        $user_id = request()->user_id;
        $tahun = Carbon::now()->year;

        $nama = User::findOrFail($user_id);

        $kinerja = Pengajuan::with('program')
            ->where('user_id', $user_id)
            ->where('status', 3)
            ->get();

        // Ambil nilai aspek dari tabel nilai_aspeks berdasarkan user_id dan tahun
        $aspeks = NilaiAspek::where('user_id', $user_id)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy('tipe'); // agar mudah dipanggil per tipe

        $row = [
            'nama_user' => $nama->nama_user,
            'nip' => $nama->nip,
            'no_hp' => $nama->no_hp,
            'alamat' => $nama->alamat,
            'tanggal' => request()->tanggal,
            'keterangan' => request()->keterangan,
            'tipe' => request()->tipe,
            'program' => $kinerja,
            'pedagogik'   => optional($aspeks->get(1))->skor,
            'kepribadian' => optional($aspeks->get(2))->skor,
            'profesional' => optional($aspeks->get(3))->skor,
            'sosial'      => optional($aspeks->get(4))->skor,

        ];

        $viewName = request()->tipe == '1'
            ? 'admin.pages.cetak.suratKinerja'
            : 'admin.pages.cetak.suratTeguran';

        $fileName = request()->tipe == '1'
            ? 'surat-kinerja_' . $nama->nama_user . '.pdf'
            : 'surat-teguran_' . $nama->nama_user . '.pdf';

        $pdf = PDF::loadView($viewName, compact('row'));
        $pdf->setPaper('folio', 'portrait');

        return $pdf->stream($fileName);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat mencetak surat: ' . $e->getMessage()
        ], 500);
    }
}

    // public function cetak(){
    //     try {
    //         $nama = User::where('id' , request()->user_id)->first();
    //         $kinerja = Pengajuan::with('program')->where('user_id' , request()->user_id)->where('status' , 6)->get();
    //         $tahun = Carbon::now()->year;

    //         $pedagogik = Pedagogik::where('user_id', 
    //         request()->user_id)
    //         ->whereYear('tanggal', $tahun)
    //         ->first();
        
    //         $kepribadian = Kepribadian::where('user_id', 
    //         request()->user_id)
    //             ->whereYear('tanggal', $tahun)
    //             ->first();
            
    //         $sosial = Sosial::where('user_id', 
    //         request()->user_id)
    //             ->whereYear('tanggal', $tahun)
    //             ->first();
            
    //         $profesional = Profesional::where('user_id', 
    //         request()->user_id)
    //             ->whereYear('tanggal', $tahun)
    //             ->first();      
                
            
    //          $row = [
    //             'nama_user' => $nama->nama_user,
    //             'nip' => $nama->nip,
    //             'no_hp' => $nama->no_hp,
    //             'alamat' => $nama->alamat,
    //             'tanggal' => request()->tanggal,
    //             'keterangan' => request()->keterangan,
    //             'tipe' => request()->tipe,
    //             'program' => $kinerja,
    //             'pedagogik' => $pedagogik->nilai,
    //             'kepribadian' => $kepribadian->nilai,
    //             'profesional' => $profesional->nilai,
    //             'sosial' => $sosial->nilai,
    //         ];


    //         $viewName = request()->tipe == '1' ? 'admin.pages.cetak.suratKinerja' : 'admin.pages.cetak.suratTeguran';
    //         $fileName = request()->tipe == '1' ? 'surat-kinerja_'.$nama->nama_user.'.pdf' : 'surat-teguran_'.$nama->nama_user.'.pdf';

    //         $pdf = PDF::loadView($viewName, compact('row'));
    //         $pdf->setPaper('folio', 'portrait');
            
    //         return $pdf->stream($fileName);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan saat mencetak surat: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function cetakGet($data){
      $row = json_decode($data, true);


     
      $row = [
        'nama_user' => $row['user']['nama_user'] , 
        'nip' => $row['user']['nip'] , 
        'no_hp' => $row['user']['no_hp'] , 
        'alamat' => $row['user']['alamat'] , 
        'tanggal' => $row['tanggal'] , 
        'keterangan' => $row['keterangan'] , 
        'tipe' => $row['tipe'] , 
        'pedagogik' => $row['aspek']['pedagogik'] , 
        'kepribadian' => $row['aspek']['kepribadian'] , 
        'profesional' => $row['aspek']['profesional'] , 
        'sosial' => $row['aspek']['sosial'] , 
      ];
      
      
      if ($row['tipe'] == '1') {
        $pdf = Pdf::loadView('admin.pages.cetak.suratKinerja' , ['row' => $row]);
        $pdf->setPaper('folio','potrait');
        $pdf->stream('suratKinerja.pdf'); 
      } else {
        $pdf = Pdf::loadView('admin.pages.cetak.suratTeguran' , ['row' => $row]);
        $pdf->setPaper('folio','potrait');
        return $pdf->stream('suratTeguran.pdf');
      }
      

    }
   
    

}


