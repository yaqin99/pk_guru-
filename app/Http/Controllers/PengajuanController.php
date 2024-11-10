<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
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
        if ($request->ajax()) {
            $data = Pengajuan::with('guru')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_kegiatan', function($row){
                    return $row->nama_kegiatan;})
                    ->addColumn('catatan', function($row){
                    return $row->catatan;})
                    ->addColumn('estimasi', function($row){
                    return $row->estimasi;})
                    ->addColumn('jumlah_poin', function($row){
                    return $row->jumlah_poin;})
                   
                    ->addColumn('action', function($row){
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'editPengajuan(`'.json_encode($row).'`)\' class="edit btn btn-warning text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deletePengajuan(`'.$row->id.'`)\' class="edit btn btn-danger text-light btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.pengajuan' , [
            'pages' => $pages , 
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

    /**
     * Store a newly created resource in storage.
     */
    public function addPengajuan(Request $request)
    {
        $user = Auth::user();
        $nameFile =  request()->file('rpp')->getClientOriginalName();

        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user, 0775, true); //creates directory
        
        }            
        // $rpp_name = uniqid().'.'.request()->file('rpp')->extension() ; 
        request()->file('rpp')->storeAs($user->nama_user.'/rpp' , $nameFile , ['disk' => 'public']);
            
        $add = Pengajuan::create([
            'nama_kegiatan' => request('nama_kegiatan'), 
            'user_id' =>  $user = Auth::user()->id, 
            'catatan' => 'aaaa', 
            'estimasi' => request('waktu'), 
            'jumlah_poin' => request('jumlah_poin'), 
            'rpp' =>  $nameFile, 
            
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
                  'catatan' => 'aaaa', 
                  'estimasi' => request('waktu'), 
                  'jumlah_poin' => request('jumlah_poin'), 
                  'rpp' =>  $nameFile, 
            ]);
        } else {
            $add = Pengajuan::where('id',request('id'))->update([
                'nama_kegiatan' => request('nama_kegiatan'), 
                    'user_id' =>  $user = Auth::user()->id, 
                    'catatan' => 'aaaa', 
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
