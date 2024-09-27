<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use App\DataTables\GurusDataTable;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = 'guru' ; 
        if ($request->ajax()) {
            $data = Guru::select(['nama_guru','nip','no_hp' , 'alamat','email','id'])->get();
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'editGuru(`'.$row.'`)\' class="edit btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           <a href="javascript:void(0)" onclick=\'deleteGuru(`'.$row['id'].'`)\' class="edit btn btn-outline-secondary btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.layout' , [
            'pages' => $pages , 
        ]);
    }
    
    public function getGuru()
    {
       $data = Guru::all();
       return response()->json($data);

    }
    public function addGuru()
    {
      $add = Guru::create([
        'nama_guru' => request('nama'), 
        'nip' => request('nip'), 
        'no_hp' => request('no_hp'), 
        'email' => request('email'), 
        'alamat' => request('alamat'), 
        'username' => request('username'), 
        'password' => bcrypt(request('password')), 
      ]);


      

    }
    public function editGuru()
    {
      $add = Guru::where('id',request('id'))->update([
        'nama_guru' => request('nama'), 
        'nip' => request('nip'), 
        'no_hp' => request('no_hp'), 
        'email' => request('email'), 
        'alamat' => request('alamat'), 
        
      ]);


      

    }
    public function deleteGuru($id)
    {
      $deltete = Guru::find($id)->delete();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        //
    }
}
