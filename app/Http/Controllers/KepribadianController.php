<?php

namespace App\Http\Controllers;

use App\Models\Kepribadian;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
                           $btn = '
                          
                           <a onclick=\'editKepribadian(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light" data-bs-toggle="modal" data-bs-target="#editKepribadian">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           
                           <a href="javascript:void(0)" onclick=\'deleteKepribadian(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.aspek.kepribadian' , [
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
    public function show(Kepribadian $kepribadian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kepribadian $kepribadian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kepribadian $kepribadian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kepribadian $kepribadian)
    {
        //
    }
}
