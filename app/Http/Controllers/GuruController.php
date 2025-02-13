<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pedagogik;
use App\Models\Kepribadian;
use App\Models\Profesional;
use App\Models\Sosial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    
    public function index(Request $request)
    {
        $pages = 'guru' ; 
        if ($request->ajax()) {
            $data = User::where('role' , 1)->get();
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('poin', function($row){
                      return $row->poin;})
                    ->addColumn('action', function($row){
                           $btn = '
                           <div class="btn-group">
                           <a onclick=\'viewAspek(`'.$row.'`)\' class="edit btn btn-primary text-light btn-sm" title="Lihat Aspek" style="cursor: pointer;">
                           <i class="bi bi-eye-fill" ></i>
                           </a>
                           <a onclick=\'editGuru(`'.$row.'`)\' class="edit btn btn-warning text-light btn-sm ml-2" title="Edit Data" style="cursor: pointer;">
                           <i class="bi bi-pencil-fill" ></i>
                           </a>
                           <a href="javascript:void(0)" onclick=\'deleteGuru(`'.$row['id'].'`)\' class="ml-2 edit btn btn-danger text-light btn-sm" title="Hapus Data" style="cursor: pointer;"><i class="bi bi-trash3-fill"></i></a>
                           
                           </div>
                           
                           ';
                           
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.guru' , [
            'pages' => $pages , 
        ]);
    }
    
    public function getAspek($id)
    {
        $type = request('type'); // Default ke pedagogik jika tidak ada type
        
        $data = match($type) {
            '1' => Pedagogik::where('user_id', $id)->get(),
            '2' => Kepribadian::where('user_id', $id)->get(),
            '3' => Profesional::where('user_id', $id)->get(),
            '4' => Sosial::where('user_id', $id)->get(),
            default => Pedagogik::where('user_id', $id)->get(),
        };
        
        return response()->json($data);
    }
    
    public function getGuru()
    {
       $data = User::all();
       return response()->json($data);

    }

    public function download($id, $dokumen, $type)
    {
        $user = User::find($id);
        
        // Tentukan folder berdasarkan tipe
        $folder = match($type) {
            '1' => 'pedagogik',
            '2' => 'kepribadian',
            '3' => 'profesional',
            '4' => 'sosial',
            default => 'pedagogik'
        };
        
        $path = storage_path("app/public/file/{$user->nama_user}/{$folder}/{$dokumen}");
        
        if (file_exists($path)) {
            return response()->download($path);
        }
        
        return response()->json(['error' => 'File tidak ditemukan'], 404);
    }

    public function addGuru()
    {
      $add = User::create([
        'nama_user' => request('nama'), 
        'nip' => request('nip'), 
        'no_hp' => request('no_hp'), 
        'email' => request('email'), 
        'alamat' => request('alamat'), 
        'username' => request('username'), 
        'password' => bcrypt(request('password')), 
        'role' =>1, 
      ]);


      

    }
    public function editGuru()
    {
      $add = User::where('id',request('id'))->update([
        'nama_user' => request('nama'), 
        'nip' => request('nip'), 
        'no_hp' => request('no_hp'), 
        'email' => request('email'), 
        'alamat' => request('alamat'), 
        
      ]);


      

    }
    public function deleteGuru($id)
    {
      $deltete = User::find($id)->delete();
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
  
}
