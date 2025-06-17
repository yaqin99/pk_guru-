<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pedagogik;
use App\Models\Kepribadian;
use App\Models\Profesional;
use App\Models\Sosial;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\WhatsAppService;

class GuruController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
    
    
    public function index(Request $request)
    {
       
        $pages = 'guru' ; 
        $mapel = Mapel::all() ; 
        if ($request->ajax()) {

            $data = User::with('mapel')
            ->where('role', 1)
            ->orderBy('kelas', 'asc')
            ->orderBy('nama_user', 'asc')
            ->get();
        
            $string = 'Konfirmasi Penghapusan Data' ; 
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('kelas', function($row){
                    
                    if($row->kelas == 1){
                       return $kelas = 'Kelas 10';
                    } 
                    if($row->kelas == 2){
                        return $kelas = 'Kelas 11';
                    } 
                    else {
                        return $kelas = 'Kelas 12';
                    }
                     })
                    ->addColumn('mapel', function($row){
                    
                     return $row->mapel->nama_mapel ;
                     })
                    ->addColumn('poin', function($row){
                      return $row->poin;})
                    ->addColumn('action', function($row){
                        if(Auth::user()->role == 3 ){
                            $btn = '
                            <div class="btn-group">
                            <a onclick=\'viewAspek(`'.$row.'`)\' class="edit btn btn-primary text-light btn-sm" title="Lihat Aspek" style="cursor: pointer;">
                            <i class="bi bi-eye-fill" ></i>
                            </a>
                            
                            </div>
                            
                            ';
                            
     
                             return $btn;
                        } else {

                        
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
                        }
                      

                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.guru' , [
            'pages' => $pages , 
            'mapels' => $mapel , 
        ]);
    }
    
    public function cekAspek()
    {
        $type = request('jenis'); // Default ke pedagogik jika tidak ada type
        
        $data = match($type) {
            '1' => Pedagogik::where('id', request('row')['id'])->update([
                'nilai' => request('nilai')
            ]),
            '2' => Kepribadian::where('id', request('row')['id'])->update([
                'nilai' => request('nilai')
            ]),
            '3' => Profesional::where('id', request('row')['id'])->update([
                'nilai' => request('nilai')
            ]),
            '4' => Sosial::where('id', request('row')['id'])->update([
                'nilai' => request('nilai')
            ]),
            default => Pedagogik::where('id', request('row')['id'])->update([
                'nilai' => request('nilai')
            ]),
        };
        
        
        return response()->json($data);
    }


    public function nilai()
    {
        $type = request('jenis'); // tipe aspek: 1=Pedagogik, 2=Kepribadian, dll
        $row = request('row');
        $userId = request('row')['user_id'];
        $nilaiBaru = request('nilai');
    
        // Update nilai aspek
        $updateResult = match($type) {
            '1' => Pedagogik::where('id', $row['id'])->update(['nilai' => $nilaiBaru]),
            '2' => Kepribadian::where('id', $row['id'])->update(['nilai' => $nilaiBaru]),
            '3' => Profesional::where('id', $row['id'])->update(['nilai' => $nilaiBaru]),
            '4' => Sosial::where('id', $row['id'])->update(['nilai' => $nilaiBaru]),
            default => Pedagogik::where('id', $row['id'])->update(['nilai' => $nilaiBaru]),
        };
    
        // Update poin user
        $user = User::find($userId);
        $admin = User::where('role', 2)->first();

        $no_admin = $admin->no_hp ;

        if ($user) {
            $user->poin += $nilaiBaru;
            $user->save();


        }

        if ( $user->poin >= 50) {
            $pesan_guru = "🎉 Selamat! Poin kinerja Anda telah mencapai 50 poin 🎉" . 
            "\nSurat Kinerja Anda sedang dalam proses oleh Admin." . 
            "\nSilahkan diperiksa dalam aplikasi" . 
            "\nTerima kasih 🙏";

            $response_guru = $this->whatsappService->sendMessage($user->no_hp, $pesan_guru);

            $pesan_admin = "Guru Atas Nama " . $user->nama_user ." Telah mencapai 50 Poin". 
            "\nTolong segera dibuatkan Surat Keterangan Kinerja." . 
            "\nTerima kasih 🙏";

            $response_guru = $this->whatsappService->sendMessage($no_admin, $pesan_admin);

        }
    
        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan dan poin berhasil ditambahkan.',
            'updated' => $updateResult,
            'new_poin' => $user->poin ?? null,
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
        'kelas' => request('kelas'), 
        'mapel_id' => request('mapel'), 
        'poin' => 0, 
        'username' => request('username'), 
        'password' => bcrypt(request('password')), 
        'role' =>1, 
      ]);

    

      

    }


    public function resetPoin()
    {
      $data = User::where('role',1)->get();
      foreach($data as $row){
        $row->poin = 0;
        $row->save();
      }
      return response()->json(['success' => true]);
    }

    public function editGuru()
    {
      $add = User::where('id',request('id'))->update([
        'nama_user' => request('nama'), 
        'nip' => request('nip'), 
        'no_hp' => request('no_hp'), 
        'email' => request('email'), 
        'alamat' => request('alamat'), 
        'kelas' => request('kelas'), 
        'mapel_id' => request('mapel'),
      ]);


      

    }
    public function deleteGuru($id)
    {
      $deltete = User::find($id)->delete();
    }

    public function deleteAspek()
    {
      $data = request()->all();
      $user = User::find($data['row']['user_id']);

      $folder = match(request('aspekType')) {
        '1' => 'pedagogik',
        '2' => 'kepribadian',
        '3' => 'profesional',
        '4' => 'sosial',
      };

      if (Storage::disk('public')->exists($user->nama_user.'/'.$folder.'/'.$data['row']['dokumen'])) {
          Storage::disk('public')->delete($user->nama_user.'/'.$folder.'/'.$data['row']['dokumen']);
      }
      $aspek = match(request('aspekType')) {
        '1' => Pedagogik::find($data['row']['id'])->delete(),
        '2' => Kepribadian::find($data['row']['id'])->delete(),
        '3' => Profesional::find($data['row']['id'])->delete(),
        '4' => Sosial::find($data['row']['id'])->delete(),
      };
      return response()->json(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeAspek(Request $request)
    {
        $data = $request->all();
        $jenisAspek = $request->jenis_aspek;
        $userId = $request->user_id; // pastikan user_id dikirim dari form
        $tahun = Carbon::parse($request->tanggal_guru_add)->format('Y');
        $cek = match ($jenisAspek) {
            '1' => Pedagogik::where('user_id', $userId)->whereYear('tanggal', $tahun)->first(),
            '2' => Kepribadian::where('user_id', $userId)->whereYear('tanggal', $tahun)->first(),
            '3' => Profesional::where('user_id', $userId)->whereYear('tanggal', $tahun)->first(),
            '4' => Sosial::where('user_id', $userId)->whereYear('tanggal', $tahun)->first(),
            default => null
        };
    
        if ($cek) {
            return response()->json([
                'status' => 'duplikat',
                'message' => 'Data aspek untuk tahun ini sudah ada.'
            ], 409); // 409 Conflict
        }
        
        $data['user_id'] = $request->user_id;
        $user = User::find($data['user_id']);

        // Membuat direktori jika belum ada
        if(!Storage::disk('public')->exists($user->nama_user)) {
            Storage::disk('public')->makeDirectory($user->nama_user);
        }

        // Pastikan jenis_aspek memiliki nilai default

        // Tentukan folder berdasarkan jenis aspek
        $folder = match($jenisAspek) {
            '1' => 'pedagogik',
            '2' => 'kepribadian',
            '3' => 'profesional',
            '4' => 'sosial',
            default => 'pedagogik'
        };

        // Jika ada file yang diupload
        if ($request->hasFile('file_aspek')) {
            $nameFile = $request->file('file_aspek')->getClientOriginalName();
            $tanggal = $request->tanggal_guru_add;
            
            // Jika ini adalah update (aspek_id ada)
            if ($request->filled('aspek_id')) {
                // Tentukan model berdasarkan jenis aspek
                $model = match($jenisAspek) {
                    '1' => Pedagogik::find($request->aspek_id),
                    '2' => Kepribadian::find($request->aspek_id),
                    '3' => Profesional::find($request->aspek_id),
                    '4' => Sosial::find($request->aspek_id),
                    default => null
                };

                // Hapus file lama jika ada
                if ($model && Storage::disk('public')->exists($user->nama_user.'/'.$folder.'/'.$model->dokumen)) {
                    Storage::disk('public')->delete($user->nama_user.'/'.$folder.'/'.$model->dokumen);
                }

                // Update data
                if ($model) {
                    $data['dokumen'] = $nameFile;
                    $data['tanggal'] = $tanggal;
                    
                    if($jenisAspek == '1'){
                        $data['nama_pedagogik'] = $request->keterangan_aspek;
                    }else if($jenisAspek == '2'){
                        $data['nama_kepribadian'] = $request->keterangan_aspek;
                    }else if($jenisAspek == '3'){
                        $data['nama_profesional'] = $request->keterangan_aspek;
                    }else if($jenisAspek == '4'){
                        $data['nama_sosial'] = $request->keterangan_aspek;
                    }

                    $model->update($data);
                }
            } else {
                // Ini adalah create baru
                $data['dokumen'] = $nameFile;
                $data['tanggal'] = $tanggal;

                if($jenisAspek == '1'){
                    $data['nama_pedagogik'] = $request->keterangan_aspek;
                }else if($jenisAspek == '2'){
                    $data['nama_kepribadian'] = $request->keterangan_aspek;
                }else if($jenisAspek == '3'){
                    $data['nama_profesional'] = $request->keterangan_aspek;
                }else if($jenisAspek == '4'){
                    $data['nama_sosial'] = $request->keterangan_aspek;
                }

                $aspek = match($jenisAspek) {
                    '1' => Pedagogik::create($data),
                    '2' => Kepribadian::create($data),
                    '3' => Profesional::create($data),
                    '4' => Sosial::create($data),
                    default => null
                };
            }

            // Upload file baru
            $request->file('file_aspek')->storeAs($user->nama_user.'/'.$folder, $nameFile, ['disk' => 'public']);
        } else if ($request->filled('aspek_id')) {
            // Update tanpa file baru
            $model = match($jenisAspek) {
                '1' => Pedagogik::find($request->aspek_id),
                '2' => Kepribadian::find($request->aspek_id),
                '3' => Profesional::find($request->aspek_id),
                '4' => Sosial::find($request->aspek_id),
                default => null
            };

            if ($model) {
                if($jenisAspek == '1'){
                    $data['nama_pedagogik'] = $request->keterangan_aspek;
                }else if($jenisAspek == '2'){
                    $data['nama_kepribadian'] = $request->keterangan_aspek;
                }else if($jenisAspek == '3'){
                    $data['nama_profesional'] = $request->keterangan_aspek;
                }else if($jenisAspek == '4'){
                    $data['nama_sosial'] = $request->keterangan_aspek;
                }

                $model->update($data);
            }
        }

        return response()->json([
            'message' => $request->filled('aspek_id') ? 'Aspek berhasil diperbarui' : 'Aspek berhasil disimpan',
            'success' => true
        ]);
    }
}
