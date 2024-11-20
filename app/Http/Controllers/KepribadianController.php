<?php

namespace App\Http\Controllers;

use App\Models\Kepribadian;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KepribadianController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'kepribadian' ; 
        if ($request->ajax()) {
            $data = Kepribadian::with('guru')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_kepribadian', function($row){
                    return $row->nama_kepribadian;})
                    ->addColumn('dokumen', function($row){
                    return $row->dokumen;})
                    
                    ->addColumn('action', function($row){
                           if (Auth::user()->role == 1) {
                            $btn = '
                          
                            <a onclick=\'editKepribadian(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editKepribadian">
                            <i class="bi bi-pencil-fill" ></i>
                            </a>
                            
                            <a href="javascript:void(0)" onclick=\'deleteKepribadian(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                           } else {
                            $btn = '
                            <div class="btn-group">
                            <a href="/storage/'.$row->guru->nama_user.'/kepribadian'.'/'.''.$row->dokumen.'"class="btn btn-primary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
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

        return view('admin.pages.aspek.kepribadian' , [
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
            
        $add = Kepribadian::create([
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
        $data = Kepribadian::find(request('id'));

        if ($name != null) {

            Storage::disk('public')->delete($user->nama_user.'/kepribadian'.'/'.$data->dokumen);

            $nameFile =  request()->file('dokumen')->getClientOriginalName();
            request()->file('dokumen')->storeAs($user->nama_user.'/kepribadian' , $nameFile , ['disk' => 'public']);
            $add = Kepribadian::where('id',request('id'))->update([
                 'nama_kepribadian' => request('nama_kepribadian'), 
                    
                  'dokumen' =>  $nameFile, 
            ]);
        } else {
            $add = Kepribadian::where('id',request('id'))->update([
                'nama_kepribadian' => request('nama_kepribadian'), 

              ]);
        }

    }

    public function deleteKepribadian($id)
    {
      $user = Auth::user();
      $data = Kepribadian::find($id);
      Storage::disk('public')->delete($user->nama_user.'/kepribadian'.'/'.$data->dokumen);
      $deltete = Kepribadian::where('id' , $id)->delete();
    }
}
