<?php

namespace App\Http\Controllers;

use App\Models\Profesional;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProfesionalController extends Controller
{ public function index(Request $request)
    {
        $pages = 'profesional' ; 
        if ($request->ajax()) {
            if (Auth::user()->role == 1) {
                # code...
                $data = Profesional::with('guru')->where('user_id' , Auth::user()->id)->get();
            } else {
                $data = Profesional::with('guru')->get();

            }


            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_profesional', function($row){
                    return $row->nama_profesional;})
                    ->addColumn('dokumen', function($row){
                    return $row->dokumen;})
                    
                    ->addColumn('action', function($row){
                        if (Auth::user()->role == 1) {
                            $btn = '
                          
                            <a onclick=\'editProfesional(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editProfesional">
                            <i class="bi bi-pencil-fill" ></i>
                            </a>
                            
                            <a href="javascript:void(0)" onclick=\'deleteProfesional(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                        } else {
                            $btn = '
                            <div class="btn-group">
                            <a href="/storage/'.$row->guru->nama_user.'/profesional'.'/'.''.$row->dokumen.'"class="btn btn-primary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
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

        return view('admin.pages.aspek.profesional' , [
            'pages' => $pages , 
        ]);
    }
    
    public function addProfesional(Request $request)
    {
        $nameFile =  request()->file('dokumen')->getClientOriginalName();
        $user = Auth::user();

        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }
        request()->file('dokumen')->storeAs($user->nama_user.'/profesional' , $nameFile , ['disk' => 'public']);
            
        $add = Profesional::create([
            'nama_profesional' => request('nama_profesional'), 
            'user_id' => $user->id, 
            'dokumen' =>  $nameFile, 
            
          ]);
          
        
    }

    public function editProfesional()
    {         
        $user = Auth::user();
        $name =  request()->file('dokumen');
        $nama_p =  request('namaFileProfesional_edit');
        $data = Profesional::find(request('id'));

        if ($name != null) {

            Storage::disk('public')->delete($user->nama_user.'/profesional'.'/'.$data->dokumen);

            $nameFile =  request()->file('dokumen')->getClientOriginalName();
            request()->file('dokumen')->storeAs($user->nama_user.'/profesional' , $nameFile , ['disk' => 'public']);
            $add = Profesional::where('id',request('id'))->update([
                 'nama_profesional' => request('nama_profesional'), 
                    
                  'dokumen' =>  $nameFile, 
            ]);
        } else {
            $add = Profesional::where('id',request('id'))->update([
                'nama_profesional' => request('nama_profesional'), 

              ]);
        }

    }

    public function deleteProfesional($id)
    {
      $user = Auth::user();
      $data = Profesional::find($id);
      Storage::disk('public')->delete($user->nama_user.'/profesional'.'/'.$data->dokumen);
      $deltete = Profesional::where('id' , $id)->delete();
    }
}
