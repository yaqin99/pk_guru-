<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = 'pengajuan' ; 
        if ($request->ajax()) {
            $data = User::with('pengajuan')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('nama_kegiatan', function($row){
                    return $row->pengajuan[0]['nama_kegiatan'];})
                    ->addColumn('catatan', function($row){
                    return $row->pengajuan[0]['catatan'];})
                    ->addColumn('jumlah_poin', function($row){
                    return $row->pengajuan[0]['jumlah_poin'];})
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        //
    }
}
