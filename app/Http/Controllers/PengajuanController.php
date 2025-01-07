<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = 'pengajuan' ; 
        $programs = Program::all();
        if ($request->ajax()) {
            if (Auth::user()->role == 1) {
                # code...
                $data = Pengajuan::with(['guru' , 'program'])->where('user_id' , Auth::user()->id)->get();
            } else {
                $data = Pengajuan::with(['guru' , 'program'])->get();

            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_kegiatan', function($row){
                    return $row->program->nama_program;})
                    ->addColumn('catatan', function($row){
                    return $row->catatan;})
                    ->addColumn('estimasi', function($row){
                    return $row->estimasi.' '.'Semester';})
                    ->addColumn('jumlah_poin', function($row){
                    return $row->jumlah_poin.' '.'Poin';})
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
                            <a href="/storage/'.$row->guru->nama_user.'/rpp'.'/'.''.$row->rpp.'"class="btn btn-primary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
                           <i class="bi bi-printer-fill" ></i>
                            </a>
                            <a onclick=\'opsi(`'.$row.'`)\' class="edit btn btn-success btn-sm text-light" >
                            <i class="bi bi-gear"></i>
                            </a>
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                         }
                         if (Auth::user()->role == 1) {
                            $btn = '
                            <div class="btn-group">
                            <a onclick=\'buktiKegiatan(`'.json_encode($row).'`)\' class="edit btn btn-success text-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#editGuru">
                            <i class="bi bi-file-earmark-pdf-fill"></i>                            
                            </a>
                            <a onclick=\'editPengajuan(`'.json_encode($row).'`)\' class="edit btn btn-warning text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
                            <i class="bi bi-pencil-fill" ></i>
                            </a>
                            
                            <a href="javascript:void(0)" onclick=\'deletePengajuan(`'.$row->id.'`)\' class="edit btn btn-danger text-light btn-sm ml-2"><i class="bi bi-trash3-fill"></i></a>
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                         } elseif (Auth::user()->role == 2) {
                            $btn = '
                            <div class="btn-group">
                            <a onclick=\'adminValidasi(`'.json_encode($row).'`)\' class="edit btn btn-success text-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#editGuru">
                            <i class="bi bi-file-earmark-pdf-fill"></i>                            
                            </a>
                            
                            <a href="/storage/'.$row->guru->nama_user.'/rpp'.'/'.''.$row->rpp.'"class="btn btn-primary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
                           <i class="bi bi-printer-fill" ></i>
                            </a>
                            
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                         }
                           
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.pengajuan' , [
            'pages' => $pages , 
            'program' => $programs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getPengajuan()
    {
        $data = User::with('pengajuan');
        
        return response()->json($data);

    }

    public function getSingleProgram()
    {
        $id = request('id');
        $data = Program::find($id);
        return response()->json($data); ; 
    }

    public function approve(Request $request)
    {
        $add = Pengajuan::where('id', $request->id)->update([
            'status' => 1, 
          ]);
    }


    public function catatan(Request $request)
    {
        $add = Pengajuan::where('id', request('id'))->update([
            'catatan' => request('catatan'), 
          ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addBuktiKegiatan(Request $request)
    {
        $user = Auth::user();
        $id = request('idBuktiKegiatan');
        $data = Pengajuan::find($id);

        $nameFile =  request()->file('fileBuktiKegiatanNama')->getClientOriginalName();
        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }   

        if(request('namaFileBuktiKegiatan') == ''){
            request()->file('fileBuktiKegiatanNama')->storeAs($user->nama_user.'/buktiKegiatan' , $nameFile , ['disk' => 'public']);
           

        } else {
            Storage::disk('public')->delete($user->nama_user.'/buktiKegiatan'.'/'.$data->bukti);
            request()->file('fileBuktiKegiatanNama')->storeAs($user->nama_user.'/buktiKegiatan' , $nameFile , ['disk' => 'public']);

        }

        $add = Pengajuan::where('id' , $id)->update([
            'bukti' => $nameFile, 
        ]);
    }
    public function addPengajuan(Request $request)
    {
        $user = Auth::user();
        $nameFile =  request()->file('rpp')->getClientOriginalName();

        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }            
        // $rpp_name = uniqid().'.'.request()->file('rpp')->extension() ; 
        request()->file('rpp')->storeAs($user->nama_user.'/rpp' , $nameFile , ['disk' => 'public']);
            
        $add = Pengajuan::create([
            'nama_kegiatan' => request('nama_kegiatan'), 
            'user_id' =>  $user = Auth::user()->id, 
            'catatan' => '', 
            'estimasi' => request('waktu'), 
            'jumlah_poin' => request('jumlah_poin'), 
            'rpp' =>  $nameFile, 
            'bukti' =>  '', 
          ]);
    }

    public function editPengajuan()
    {         
        $user = Auth::user();
        $name =  request()->file('rpp');
        $nama_rpp =  request('rpp_name');
        $data = Pengajuan::find(request('id'));

        if ($name != null) {
            Storage::disk('public')->delete($user->nama_user.'/rpp'.'/'.$data->rpp);

            $nameFile =  request()->file('rpp')->getClientOriginalName();
            request()->file('rpp')->storeAs($user->nama_user.'/rpp' , $nameFile , ['disk' => 'public']);
            $add = Pengajuan::where('id',request('id'))->update([
              'nama_kegiatan' => request('nama_kegiatan'), 
                  'user_id' =>  $user = Auth::user()->id,
                  'estimasi' => request('waktu'), 
                  'jumlah_poin' => request('jumlah_poin'), 
                  'rpp' =>  $nameFile, 
            ]);
        } else {
            $add = Pengajuan::where('id',request('id'))->update([
                'nama_kegiatan' => request('nama_kegiatan'), 
                    'user_id' =>  $user = Auth::user()->id, 
                    'estimasi' => request('waktu'), 
                    'jumlah_poin' => request('jumlah_poin'), 
              ]);
        }
        


      

    }
    public function deletePengajuan($id)
    {
      $user = Auth::user();
      $data = Pengajuan::find($id);
      Storage::disk('public')->delete($user->nama_user.'/rpp'.'/'.$data->rpp);
      $deltete = Pengajuan::where('id' , $id)->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        //
    }
}
