<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $pages = 'surat' ; 
        if ($request->ajax()) {
            $data = Surat::with('user')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->user->nama_user;})
                    ->addColumn('detail_surat', function($row){
                    return $row->detail_surat;})
                    ->addColumn('tipe', function($row){
                    return $row->tipe;})
                    ->addColumn('tanggal', function($row){
                    return $row->tanggal;})
                    
                    ->addColumn('action', function($row){
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'cetakSurat(`'.$row.'`)\' class="edit btn btn-primary btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editGuru">
                           <i class="bi bi-printer-fill" ></i>
                           </a>
                           <a onclick=\'editSurat(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editGuru">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deleteSurat(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.surat' , [
            'pages' => $pages , 
        ]);
    }
    public function create()
    {
        //
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
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        //
    }
}
