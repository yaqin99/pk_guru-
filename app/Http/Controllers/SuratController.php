<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use App\Models\Aspek;
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
                        ->where('status' , 4)
                        ->join('aspeks', 'surat_kinerjas.id', '=', 'aspeks.surat_kinerja_id')
                        ->orderBy('surat_kinerjas.id', 'desc')
                        ->get();
          } 
          else if (Auth::user()->role == 3) {
            $data = Surat::with(['user' , 'aspek'])
                        ->where('status' , 2)
                        ->join('aspeks', 'surat_kinerjas.id', '=', 'aspeks.surat_kinerja_id')
                        ->orderBy('surat_kinerjas.id', 'desc')
                        ->get();
           
          } else {
            $data = Surat::with(['user' , 'aspek'])
                        ->join('aspeks', 'surat_kinerjas.id', '=', 'aspeks.surat_kinerja_id')
                        ->orderBy('surat_kinerjas.id', 'desc')
                        ->get();
          }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->user->nama_user;})
                    ->addColumn('nama_surat', function($row){
                    return $row->nama_surat;})
                    ->addColumn('tipe', function($row){
                    return $row->tipe;})
                    ->addColumn('tanggal', function($row){
                    return $row->tanggal;})
                    ->addColumn('status', function($row){
                      if ($row->status == null || $row->status == 1) {
                       
                        return $status = 'Menunggu' ; 
                        
 
                        
                      } else if ($row->status == 2) {
                        return $status = 'Menunggu Persetujuan' ; 
                      } else if ($row->status == 3) {
                        return $status = 'Ditolak' ; 
                      } else {
                        return $status = 'Disetujui' ; 

                      };
                    })
                    
                    ->addColumn('penerusan', function($row){
                      if (Auth::user()->role == 3) {
                        $btn = '
                        <div class="btn-group">
                        <a onclick=\'approve(`'.$row->id.'`)\' class="ml-2 edit btn btn-success btn-sm text-light" >
                        <i class="bi bi-check-lg" ></i>
                        </a>
                        <a onclick=\'tolakSurat(`'.$row->id.'`)\' class="ml-2 edit btn btn-danger  btn-sm text-light" >
                        <i class="bi bi-arrow-left-short" ></i>
                        </a>
                        </div>
                        
                        ';
                        return $btn;

                      }
                      if (Auth::user()->role == 2) {
                         if ($row->status == 3) {
                          $btn = '
                          
                          ';
                          return $btn;
                         } else {
                          if ($row->status != 1) {
                            $btn = '
                            
                            ';
                            return $btn;
                          } else {
                            $btn = '
                          <div class="btn-group">
                          <a onclick=\'teruskanSurat(`'.$row.'`)\' class="ml-2 edit btn btn-success btn-sm text-light" >
                          <i class="bi bi-arrow-right-short" ></i>
                          </a>
                          
                          </div>
                          
                          ';
                          
   
                           return $btn;
                          }
                         
                         }
                      }
                           
                    })
                    ->addColumn('action', function($row){
                      if (Auth::user()->role == 3) {
                        $btn = '
                        <div class="btn-group">
                        <a onclick=\'cetakSurat(`'.$row.'`)\' class="ml-2 edit btn btn-primary btn-sm text-light" >
                        <i class="bi bi-printer-fill" ></i>
                        </a>
                       
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

                        if ($row->status == 3) {
                          $btn = '
                          <div class="btn-group">
                        
                          
                          </div>
                          
                          ';
                          return $btn;
                        } 
                         else {
                          $btn = '
                        <div class="btn-group">
                        <a onclick=\'cetakSurat(`'.$row.'`)\' class="ml-2 edit btn btn-primary btn-sm text-light" >
                        <i class="bi bi-printer-fill" ></i>
                        </a>
                        <a onclick=\'suratAspek(`'.$row->id.'`)\' class="ml-2 edit btn btn-success btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editAspek">
                        <i class="bi bi-file-earmark-bar-graph" ></i>
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
              'status' => 1,
            ]);
          } else {
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Kinerja'.' '.date("Y"), 
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


    public function cetak(){
        try {
            $nama = User::where('id' , request()->user_id)->first();
            $row = [
                'nama_user' => $nama->nama_user,
                'nip' => $nama->nip,
                'no_hp' => $nama->no_hp,
                'alamat' => $nama->alamat,
                'tanggal' => request()->tanggal,
                'keterangan' => request()->keterangan,
                'tipe' => request()->tipe,
                'pedagogik' => request('pedagogik'),
                'kepribadian' => request('kepribadian'),
                'profesional' => request('profesional'),
                'sosial' => request('sosial'),
            ];


            $viewName = request()->tipe == '1' ? 'admin.pages.cetak.suratKinerja' : 'admin.pages.cetak.suratTeguran';
            $fileName = request()->tipe == '1' ? 'surat-kinerja.pdf' : 'surat-teguran.pdf';

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


