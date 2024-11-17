<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use App\Models\Aspek;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spipu\Html2Pdf\Html2Pdf;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF as DomPDFPDF;
// use Dompdf\Dompdf;
// use NahidulHasan\Html2pdf\Pdf;
// use TCPDF_FONTS;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'surat' ; 
        
        $guru = User::select('nama_user' , 'id')->get();
        if ($request->ajax()) {
            $data = Surat::with(['user' , 'aspek'])->get();

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
                    
                    ->addColumn('action', function($row){
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
                    })
                    ->rawColumns(['action'])
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
    public function addSurat(Request $request)
    {
        
        if(request('tipe_surat') == 1){
            $add = Surat::create([
                'user_id' => request('nama_user'), 
                'nama_surat' => 'Surat Kinerja'.' '.date("Y"), 
                'tipe' => request('tipe_surat'),
                'tanggal' => request('tanggal'), 
                'keterangan' => request('keterangan'), 
                
              ]);

              Aspek::create([
                'surat_kinerja_id' => $add->id  , 
                'pedagogik' => null, 
                'kepribadian' => null, 
                'profesional' => null,
                'sosial' => null, 
              ]);

        } else {
            $add = Surat::create([
                'user_id' => request('nama_user'), 
                'nama_surat' => 'Surat Teguran'.' '.date("Y"), 
                'tipe' => request('tipe_surat'),
                'tanggal' => request('tanggal'), 
                'keterangan' => request('keterangan'), 
                
              ]);

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
      
     $pdf = Pdf::loadView('admin.pages.cetak.suratKinerja');
     
     $pdf->setPaper('folio','potrait');
     return $pdf->stream('suratKinerja.pdf'); 
    //  return view('admin.pages.cetak.suratKinerja');
    //  nama ekstensinya menentukan tipe download file
    //   return $pdf->download('invoice.pdf');
    
;
    }
    

}


