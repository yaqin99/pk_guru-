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


class SuratController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'surat' ; 
        
        $guru = User::select('nama_user' , 'id')->where('role' , 1)->get();
        if ($request->ajax()) {
          if (Auth::user()->role == 1) {
            $data = Surat::with(['user' , 'aspek'])->where('status' , 1)->get();
          } 
          else {
            $data = Surat::with(['user' , 'aspek'])->get();
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
                      if ($row->status == null || $row->status == 0) {
                       
                        return $status = 'Menunggu' ; 
                        
 
                        
                      } else {
                        return $status = 'Disetujui' ; 

                      };
                    })
                    
                    ->addColumn('action', function($row){
                      if (Auth::user()->role == 3) {
                        $btn = '
                        <div class="btn-group">
                        <a onclick=\'cetakSurat(`'.$row.'`)\' class="edit btn btn-primary btn-sm text-light" >
                        <i class="bi bi-printer-fill" ></i>
                        </a>
                        <a onclick=\'approve(`'.$row->id.'`)\' class="edit btn btn-success btn-sm text-light" >
                        <i class="bi bi-check-lg" ></i>
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
                        $btn = '
                           <div class="btn-group">
                           <a onclick=\'cetakSurat(`'.$row.'`)\' class="edit btn btn-primary btn-sm text-light" >
                           <i class="bi bi-printer-fill" ></i>
                           </a>
                           <a onclick=\'editAspek(`'.$row->id.'`)\' class="edit btn btn-success btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editAspek">
                           <i class="bi bi-file-earmark-bar-graph" ></i>
                           </a>
                           <a onclick=\'editSurat(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editSurat">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deleteSurat(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                      }
                           
                    })
                    ->rawColumns(['status','action'])
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
    public function approve(Request $request)
    {
        
        $add = Surat::where('id', $request->id)->update([
            'status' => 1, 
            
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
              
            ]);
          } else {
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Kinerja'.' '.date("Y"), 
              'tipe' => request('tipe_surat'),
              'tanggal' => request('tanggal'), 
              'keterangan' => request('keterangan'), 
              
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
              
            ]);
          } else {
            $add = Surat::create([
              'user_id' => request('nama_user'), 
              'nama_surat' => 'Surat Teguran'.' '.date("Y"), 
              'tipe' => request('tipe_surat'),
              'tanggal' => request('tanggal'), 
              'keterangan' => request('keterangan'), 
              
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


    public function cetak(){
      $row = [
        'nama_user' => request()->user['nama_user'] , 
        'nip' => request()->user['nip'] , 
        'no_hp' => request()->user['no_hp'] , 
        'alamat' => request()->user['alamat'] , 
        'tanggal' => request()->tanggal , 
        'keterangan' => request()->keterangan , 
        'tipe' => request()->tipe , 
        'pedagogik' => request()->aspek['pedagogik'] , 
        'kepribadian' => request()->aspek['kepribadian'] , 
        'profesional' => request()->aspek['profesional'] , 
        'sosial' => request()->aspek['sosial'] , 
      ];
      
      
      if ($row['tipe'] == '1') {
        $pdf = Pdf::loadView('admin.pages.cetak.suratKinerja' , ['row' => $row]);
        $pdf->setPaper('folio','potrait');
        return $pdf->stream('suratKinerja.pdf'); 
      } else {
        $pdf = Pdf::loadView('admin.pages.cetak.suratTeguran' , ['row' => $row]);
        $pdf->setPaper('folio','potrait');
        return $pdf->stream('suratTeguran.pdf');
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


