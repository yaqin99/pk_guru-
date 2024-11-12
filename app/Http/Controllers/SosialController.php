<?php

namespace App\Http\Controllers;

use App\Models\Sosial;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SosialController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'sosial' ; 
        if ($request->ajax()) {
            $data = Sosial::with('guru')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_sosial', function($row){
                    return $row->nama_sosial;})
                    ->addColumn('dokumen', function($row){
                    return $row->dokumen;})
                    
                    ->addColumn('action', function($row){
                           $btn = '
                          
                           <a onclick=\'editSosial(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editSosial">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deleteSosial(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.aspek.sosial' , [
            'pages' => $pages , 
        ]);
    }
    
    public function addSosial(Request $request)
    {
        $nameFile =  request()->file('dokumen')->getClientOriginalName();
        $user = Auth::user();

        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }
        request()->file('dokumen')->storeAs($user->nama_user.'/sosial' , $nameFile , ['disk' => 'public']);
            
        $add = Sosial::create([
            'nama_sosial' => request('nama_sosial'), 
            'user_id' => $user->id, 
            'dokumen' =>  $nameFile, 
            
          ]);
          
        
    }

    public function editSosial()
    {         
        $user = Auth::user();
        $name =  request()->file('dokumen');
        $nama_p =  request('namaFilesosial_edit');
        $data = Sosial::find(request('id'));

        if ($name != null) {

            Storage::disk('public')->delete($user->nama_user.'/sosial'.'/'.$data->dokumen);

            $nameFile =  request()->file('dokumen')->getClientOriginalName();
            request()->file('dokumen')->storeAs($user->nama_user.'/sosial' , $nameFile , ['disk' => 'public']);
            $add = Sosial::where('id',request('id'))->update([
                 'nama_sosial' => request('nama_sosial'), 
                    
                  'dokumen' =>  $nameFile, 
            ]);
        } else {
            $add = Sosial::where('id',request('id'))->update([
                'nama_sosial' => request('nama_sosial'), 

              ]);
        }

    }

    public function deleteSosial($id)
    {
      $user = Auth::user();
      $data = Sosial::find($id);
      Storage::disk('public')->delete($user->nama_user.'/sosial'.'/'.$data->dokumen);
      $deltete = Sosial::where('id' , $id)->delete();
    }
}
