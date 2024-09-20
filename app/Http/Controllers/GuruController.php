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
            $data = Guru::select(['nama_guru','nip','no_hp' , 'alamat','id'])->get();
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'editGuru(`'.$row.'`)\' class="edit btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditWilayah">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           <a href="/admin/hapusGuru/'.$row['id'].'" onclick="return confirm(\'Konfirmasi Penghapusan Data ?\')"  class="edit btn btn-outline-secondary btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
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
