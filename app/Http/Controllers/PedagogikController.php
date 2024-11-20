<?php

namespace App\Http\Controllers;

use App\Models\Pedagogik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class PedagogikController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'pedagogik' ; 
        if ($request->ajax()) {
            $data = Pedagogik::with('guru')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_pedagogik', function($row){
                    return $row->nama_pedagogik;})
                    ->addColumn('dokumen', function($row){
                    return $row->dokumen;})
                    
                    ->addColumn('action', function($row){
                        if (Auth::user()->role == 1) {
                            $btn = '
                          
                           <a onclick=\'editPedagogik(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editPedagogik">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deletePedagogik(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                        } else {
                            $btn = '
                            <div class="btn-group">
                            <a href="/storage/'.$row->guru->nama_user.'/pedagogik'.'/'.''.$row->dokumen.'"class="btn btn-primary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
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

        return view('admin.pages.aspek.pedagogik' , [
            'pages' => $pages , 
        ]);
    }
    public function addPedagogik(Request $request)
    {
        $nameFile =  request()->file('dokumen')->getClientOriginalName();
        $user = Auth::user();

        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }
        request()->file('dokumen')->storeAs($user->nama_user.'/pedagogik' , $nameFile , ['disk' => 'public']);
            
        $add = Pedagogik::create([
            'nama_pedagogik' => request('nama_pedagogik'), 
            'user_id' => $user->id, 
            'dokumen' =>  $nameFile, 
            
          ]);
          
        
    }

    public function editPedagogik()
    {         
        $user = Auth::user();
        $name =  request()->file('dokumen');
        $nama_p =  request('namaFilePedagogik_edit');
        $data = Pedagogik::find(request('id'));

        if ($name != null) {

            Storage::disk('public')->delete($user->nama_user.'/pedagogik'.'/'.$data->dokumen);

            $nameFile =  request()->file('dokumen')->getClientOriginalName();
            request()->file('dokumen')->storeAs($user->nama_user.'/pedagogik' , $nameFile , ['disk' => 'public']);
            $add = Pedagogik::where('id',request('id'))->update([
                 'nama_pedagogik' => request('nama_pedagogik'), 
                    
                  'dokumen' =>  $nameFile, 
            ]);
        } else {
            $add = Pedagogik::where('id',request('id'))->update([
                'nama_pedagogik' => request('nama_pedagogik'), 

              ]);
        }
        


      

    }

    public function deletePedagogik($id)
    {
      $user = Auth::user();
      $data = Pedagogik::find($id);
      Storage::disk('public')->delete($user->nama_user.'/pedagogik'.'/'.$data->dokumen);
      $deltete = Pedagogik::where('id' , $id)->delete();
    }

}
