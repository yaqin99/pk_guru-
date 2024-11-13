<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspekController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'aspek' ; 
        if ($request->ajax()) {
            $data = Aspek::with('surat.user')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_surat', function($row){
                    return $row->surat->nama_surat;})
                    ->addColumn('pedagogik', function($row){
                    return $row->pedagogik;})
                    ->addColumn('kepribadian', function($row){
                    return $row->kepribadian;})
                    
                    ->addColumn('profesional', function($row){
                    return $row->profesional;})
                    ->addColumn('sosial', function($row){
                    return $row->sosial;})
                    
                    ->addColumn('action', function($row){
                           $btn = '
                          
                           <a onclick=\'editAspek(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editAspek">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deleteAspek(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.aspek.aspek' , [
            'pages' => $pages , 
        ]);
    }
    
    public function addKepribadian(Request $request)
    {
        $nameFile =  request()->file('dokumen')->getClientOriginalName();
        $user = Auth::user();

        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }
        request()->file('dokumen')->storeAs($user->nama_user.'/kepribadian' , $nameFile , ['disk' => 'public']);
            
        $add = Aspek::create([
            'nama_kepribadian' => request('nama_kepribadian'), 
            'user_id' => $user->id, 
            'dokumen' =>  $nameFile, 
            
          ]);
          
        
    }

    public function editKepribadian()
    {         
        $user = Auth::user();
        $name =  request()->file('dokumen');
        $nama_p =  request('namaFileKepribadian_edit');
        $data = Aspek::find(request('id'));

        if ($name != null) {

            Storage::disk('public')->delete($user->nama_user.'/kepribadian'.'/'.$data->dokumen);

            $nameFile =  request()->file('dokumen')->getClientOriginalName();
            request()->file('dokumen')->storeAs($user->nama_user.'/kepribadian' , $nameFile , ['disk' => 'public']);
            $add = Aspek::where('id',request('id'))->update([
                 'nama_kepribadian' => request('nama_kepribadian'), 
                    
                  'dokumen' =>  $nameFile, 
            ]);
        } else {
            $add = Aspek::where('id',request('id'))->update([
                'nama_kepribadian' => request('nama_kepribadian'), 

              ]);
        }

    }

    public function deleteKepribadian($id)
    {
      $user = Auth::user();
      $data = Aspek::find($id);
      Storage::disk('public')->delete($user->nama_user.'/kepribadian'.'/'.$data->dokumen);
      $deltete = Aspek::where('id' , $id)->delete();
    }
}
