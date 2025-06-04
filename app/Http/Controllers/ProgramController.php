<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
   
    public function index(Request $request)
    {
        $pages = 'program' ; 
        if ($request->ajax()) {
            $data = Program::orderBy('id' , 'DESC')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_program', function($row){
                        return $row->nama_program;})
                    ->addColumn('poin', function($row){
                        return $row->poin.' '.'Poin';})
                    ->addColumn('pelaksanaan', function($row){
                        
                       
                        return $row->pelaksanaan.' '.'Semester';
                    
                    
                    })
                    ->addColumn('tahun', function($row){
                        
                       
                        return $row->tahun;
                    
                    
                    })
                    ->addColumn('status', function($row){
                        
                       
                        return $row->status == 1 ? 'Aktif' : 'Tidak Aktif';
                    
                    
                    })
                    ->addColumn('action', function($row){
                          if(Auth::user()->role == 2){
                            $btn = '
                           <div class="btn-group">
                           <a onclick=\'editProgram(`'.$row.'`)\' class="edit btn btn-warning text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editProgram">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           <a href="javascript:void(0)" onclick=\'deleteProgram(`'.$row['id'].'`)\' class="edit btn btn-danger text-light btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                          }
                          if(Auth::user()->role == 3){
                            $btn = '
                           <div class="btn-group">
                           
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                          }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.program' , [
            'pages' => $pages , 
        ]);
    }
    
  
   
    public function addProgram()
    {
        if (request('idProgram') == '') {
            $add = Program::create([
                'nama_program' => request('nama_program'), 
                'poin' => request('poin'), 
                'pelaksanaan' => request('pelaksanaan'), 
                'status' => 1,
                'tahun' => request('tahun'),
              ]);
        } else {
            $add = Program::where('id' , request('idProgram') )->update([
                'nama_program' => request('nama_program'), 
                'poin' => request('poin'), 
                'pelaksanaan' => request('pelaksanaan'), 
                'status' => request('status'),
                'tahun' => request('tahun'),
              ]);
        }
    }
    public function deleteProgram($id)
    {
      $deltete = Program::find($id)->delete();
    }
}
