<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class PengajuanController extends Controller
{

    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
    
    public function sendWhatsApp()
    {
        $phone   = '08999920375'; // Nomor tujuan
        $message = 'Halo, ini pesan otomatis dari Laravel 10 menggunakan Fonnte!';

        $response = $this->whatsappService->sendMessage($phone, $message);

        return response()->json($response);
    }
  


    public function index(Request $request)
    {
        $pages = 'pengajuan' ; 
        $programs = Program::where('status' , 1)->get();
        if ($request->ajax()) {
            if (Auth::user()->role == 1) {
                # code...
                $data = Pengajuan::with(['guru' , 'program'])->where('user_id' , Auth::user()->id)->orderBy('tanggal' , 'desc')->orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->get();
            }
            if (Auth::user()->role == 3) {
                // $data = Pengajuan::with(['guru' , 'program'])->whereIn('status' , [3])->orderBy('tanggal' , 'desc')->get();
                $data = Pengajuan::with(['guru' , 'program'])->orderBy('tanggal' , 'desc')->orderBy('created_at', 'desc')->get();

            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_user', function($row){
                    return $row->guru->nama_user;})
                    ->addColumn('nama_kegiatan', function($row){
                    return $row->program->nama_program;})
                    
                    ->addColumn('catatan', function($row){
                    return $row->catatan;})
                    // ->addColumn('catatan_admin', function($row){
                    // return $row->catatan_admin;})
                    
                    ->addColumn('estimasi', function($row){
                    return $row->estimasi.' '.'Semester';})
                    ->addColumn('jumlah_poin', function($row){
                    return $row->jumlah_poin.' '.'Poin';})
                    // ->addColumn('tanggal', function($row){
                    // Carbon::setLocale('id');

                    // return Carbon::parse($row->tanggal)->translatedFormat('l, d F Y');})
                    ->addColumn('status', function($row){
                       
                        if ($row->status == 2) {                
                          return $status = 'Menunggu' ; 
                        } 
                        if ($row->status == 3) {                
                          return $status = 'Selesai' ; 
                        } 
                        if ($row->status == 4) {                
                          return $status = 'Ditolak' ; 
                        } 
                        if ($row->status == 5) {                
                          return $status = 'Revisi Kepsek' ; 
                        } 
                      })
                   
                    ->addColumn('action', function($row){
                        if (Auth::user()->role == 3) {
                            if ($row->status == 2) {
                                $rpp = asset('storage/' . $row->guru->nama_user . '/rpp/' . $row->rpp);
                                $bukti = asset('storage/' . $row->guru->nama_user . '/bukti/' . $row->bukti);
                                $btn = '
                                <div class="btn-group">
                                <a  id="btn-buka-pdf"  data-rpp="'.$rpp.'" data-bukti="'.$bukti.'" class="btn btn-primary text-light btn-sm" title="Cetak Berkas">
                                    <i class="bi bi-printer-fill" ></i>
                                </a>
                              
                                <a onclick=\'tolakPengajuan(`'.$row->id.'`)\' class="edit btn btn-danger btn-sm text-light ml-2" title="Tolak Pengajuan" >
                                <i class="bi bi-x-circle-fill"></i>
                                </a>
                                <a onclick=\'kepsekValidasi(`'.$row.'`)\' class="edit btn btn-success btn-sm text-light ml-2" title="Setujui Pengajuan" >
                                <i class="bi bi-check-circle-fill"></i>
                                </a>
                                
                                <a onclick=\'opsi(`'.$row.'`)\' class="edit btn btn-warning btn-sm text-light ml-2" title="Berikan Catatan" >
                                <i class="bi bi-card-text"></i>
                                </a>
                                
                                </div>
                                
                                ';
                                
         
                                 return $btn;
                            } 
                            else {
                                $rpp = asset('storage/' . $row->guru->nama_user . '/rpp/' . $row->rpp);
                                $bukti = asset('storage/' . $row->guru->nama_user . '/bukti/' . $row->bukti);
                                $btn = '
                                <div class="btn-group">
                               <a  id="btn-buka-pdf"  data-rpp="'.$rpp.'" data-bukti="'.$bukti.'" class="btn btn-primary text-light btn-sm" title="Cetak Berkas">
                                    <i class="bi bi-printer-fill" ></i>
                                </a>
                                </div>
                                ';
                                 return $btn;
                            }
                         }
                         if (Auth::user()->role == 1) {
                            if ($row->status == 3 || $row->status == 4) {
                                $btn = '
                                
                                
                                ';
                                
                                // $btn = '
                                // <div class="btn-group">
                                // <a onclick=\'buktiKegiatan(`'.json_encode($row).'`)\' class="edit btn btn-success text-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#editGuru" title="Bukti Kegiatan" >
                                // <i class="bi bi-file-earmark-pdf-fill"></i>                            
                                // </a>
                                
                                // </div>
                                
                                // ';
                                
                            } 
                            else {
                                $btn = '
                                <div class="btn-group">
                                
                                <a onclick=\'editPengajuan(`'.json_encode($row).'`)\' class="edit btn btn-warning text-light btn-sm" data-bs-toggle="modal" data-bs-target="#editGuru" title="Edit Pengajuan" >
                                <i class="bi bi-pencil-fill" ></i>
                                </a>
                                
                                <a href="javascript:void(0)" onclick=\'deletePengajuan(`'.$row->id.'`)\' class="edit btn btn-danger text-light btn-sm ml-2" title="Hapus Pengajuan" ><i class="bi bi-trash3-fill"></i></a>
                                
                                </div>
                                
                                ';
                                
                            }
                            
     
                             return $btn;
                         } 
                        
                           
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.pages.pengajuan' , [
            'pages' => $pages , 
            'program' => $programs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function sendToKepsek()
    {
        $data = Pengajuan::find(request('id'));
        $no_guru = User::find($data->user_id)->no_hp;
        $no_kepsek = User::where('role' , 3)->first();

        
        $add = Pengajuan::where('id',request('id'))->update([
                'status' => 3, 
          ]);
        
        $message_kepsek = "Ada pengajuan kegiatan yang menunggu persetujuan dari Anda". 
          "\nMohon untuk segera diperiksa".
          "\nTerima Kasih";
          
        $response_kepsek = $this->whatsappService->sendMessage($no_kepsek->no_hp, $message_kepsek);
        
        $message_guru = "Pengajuan Anda Telah Diteruskan ke Kepala Sekolah". 
                   "\nMohon tunggu konfirmasi dari Kepala Sekolah".
                   "\nTerima Kasih";

        
        $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);
    }
    public function adminValidasi()
    {
        try {
            $user = User::find(request('user_id'));
            $newPoin = $user->poin + request('jumlah_poin');
            
            // Update poin user
            User::where('id', request('user_id'))->update([
                'poin' => $newPoin,
            ]);

            // Update status pengajuan
            Pengajuan::where('id', request('id'))->update([
                'status' => 3, 
            ]);

            // Kirim notifikasi WhatsApp ke guru
            $data = Pengajuan::find(request('id'));
            $admin = User::where('role', 2)->first();
            $no_guru = $user->no_hp;
            $no_admin = $admin->no_hp;
            
            $message_guru = "Pengajuan Anda Telah Diselesaikan oleh Admin". 
                "\nSilahkan periksa poin perolehan anda".
                "\nApabila poin sudah mencukupi maka admin akan mengeluarkan surat kinerja".
                "\nTerima Kasih";

            $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);

            // Cek apakah poin sudah mencapai 20
            $response = [
                'success' => true,
                'message' => 'Pengajuan berhasil divalidasi',
                'needCertificate' => false
            ];

            if ($newPoin >= 20) {

                $pesan_guru = "🎉 Selamat! Poin kinerja Anda telah mencapai 20 poin 🎉" . 
                "\nSurat Kinerja Anda sedang dalam proses oleh Admin." . 
                "\nSilahkan diperiksa dalam aplikasi" . 
                "\nTerima kasih 🙏";

                $response_guru = $this->whatsappService->sendMessage($no_guru, $pesan_guru);

                $pesan_admin = "Guru Atas Nama " . $user->nama_user ." Telah mencapai 20 Poin". 
                "\nTolong segera dibuatkan Surat Keterangan Kinerja." . 
                "\nTerima kasih 🙏";

                $response_guru = $this->whatsappService->sendMessage($no_admin, $pesan_admin);

                $response['needCertificate'] = true;
                $response['message'] = 'Pengajuan berhasil divalidasi. '. $user->nama_user.' telah mencapai 20 poin dan berhak mendapatkan surat keterangan kinerja.';
                $response['guru'] = [
                    'nama' => $user->nama_user,
                    'poin' => $newPoin
                ];

                

            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function kepsekValidasi()
    {
        try {
            $user = User::find(request('user_id'));
            $newPoin = $user->poin + request('jumlah_poin');
            
            // Update poin user
            User::where('id', request('user_id'))->update([
                'poin' => $newPoin,
            ]);

            // Update status pengajuan
            Pengajuan::where('id', request('id'))->update([
                'status' => 3, 
            ]);

            // Kirim notifikasi WhatsApp ke guru
            $data = Pengajuan::find(request('id'));
            $admin = User::where('role', 2)->first();
            $no_guru = $user->no_hp;
            $no_admin = $admin->no_hp;
            
            $message_guru = "Pengajuan Anda Telah Divalidasi oleh Kepala Sekolah". 
                "\nSilahkan periksa poin perolehan anda".
                "\nApabila poin sudah mencukupi maka admin akan mengeluarkan surat kinerja".
                "\nTerima Kasih";

            $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);

            // Cek apakah poin sudah mencapai 20
            $response = [
                'success' => true,
                'message' => 'Pengajuan berhasil divalidasi',
                'needCertificate' => false
            ];

            if ($newPoin >= 20) {

                $pesan_guru = "🎉 Selamat! Poin kinerja Anda telah mencapai 20 poin 🎉" . 
                "\nSurat Kinerja Anda sedang dalam proses oleh Admin." . 
                "\nSilahkan diperiksa dalam aplikasi" . 
                "\nTerima kasih 🙏";

                $response_guru = $this->whatsappService->sendMessage($no_guru, $pesan_guru);

                $pesan_admin = "Guru Atas Nama " . $user->nama_user ." Telah mencapai 20 Poin". 
                "\nTolong segera dibuatkan Surat Keterangan Kinerja." . 
                "\nTerima kasih 🙏";

                $response_guru = $this->whatsappService->sendMessage($no_admin, $pesan_admin);

                $response['needCertificate'] = true;
                $response['message'] = 'Pengajuan berhasil divalidasi. '. $user->nama_user.' telah mencapai 20 poin dan berhak mendapatkan surat keterangan kinerja.';
                $response['guru'] = [
                    'nama' => $user->nama_user,
                    'poin' => $newPoin
                ];

                

            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }



    public function getPengajuan()
    {
        $data = User::with('pengajuan');
        
        return response()->json($data);

    }

    public function getSingleProgram()
    {
        $id = request('id');
        $data = Program::find($id);
        return response()->json($data); ; 
    }

    public function approve(Request $request)
    {
        $add = Pengajuan::where('id', $request->id)->update([
            'status' => 3, 
          ]);

        $data = Pengajuan::find(request('id'));
        $no_guru = User::find($data->user_id)->no_hp;

        $message_guru = "Pengajuan Anda Telah Disetujui oleh Kepala Sekolah". 
          "\nSilahkan melaksanakan kegiatan mengajar anda".
          "\nTerima Kasih";


        $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);
    }
    public function tolak(Request $request)
    {
        $add = Pengajuan::where('id', $request->id)->update([
            'status' => 4, 
            'catatan' => $request->catatan,
          ]);

          $data = Pengajuan::find(request('id'));
          $no_guru = User::find($data->user_id)->no_hp;
  
          $message_guru = "Pengajuan Anda Telah Ditolak oleh Kepala Sekolah". 
              "\ndengan alasan: ". $request->catatan.
              "\nSilahkan ajukan pengajuan baru dengan format yang sesuai".
              "\nTerima Kasih";
  
  
          $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru); 
    }

    public function perbaiki(Request $request)
    {
        $add = Pengajuan::where('id', $request->id)->update([
            'status' => 1, 
            'catatan_admin' => $request->catatan_admin,
          ]);
        
        $data = Pengajuan::find(request('id'));
        $no_guru = User::find($data->user_id)->no_hp;
  
        $message_guru = "Ada perbaikan dalam pengajuan anda oleh admin". 
            "\ndengan catatan: ". $request->catatan_admin.
            "\nMohon untuk segera melakukan perbaikan".
            "\nTerima Kasih";
  
  
        $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);
    }
    public function catatan(Request $request)
    {
        $add = Pengajuan::where('id', request('id'))->update([
            'catatan' => request('catatan'), 
            'status' => 5, 

            ]);

        $data = Pengajuan::find(request('id'));
        $no_guru = User::find($data->user_id)->no_hp;

        $message_guru = "Ada perbaikan dalam pengajuan anda oleh Kepala Sekolah". 
            "\ndengan catatan: ". request('catatan').
            "\nMohon untuk segera melakukan perbaikan".
            "\nTerima Kasih";


        $response_guru = $this->whatsappService->sendMessage($no_guru, $message_guru);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addBuktiKegiatan(Request $request)
    {
        $user = Auth::user();
        $id = request('idBuktiKegiatan');
        $data = Pengajuan::find($id);

        $nameFile =  request()->file('fileBuktiKegiatanNama')->getClientOriginalName();
        if(!Storage::disk('public')->exists($user->nama_user)) {

            Storage::disk('public')->makeDirectory($user->nama_user); //creates directory
        
        }   

        if(request('namaFileBuktiKegiatan') == ''){
            request()->file('fileBuktiKegiatanNama')->storeAs($user->nama_user.'/buktiKegiatan' , $nameFile , ['disk' => 'public']);
           

        } else {
            Storage::disk('public')->delete($user->nama_user.'/buktiKegiatan'.'/'.$data->bukti);
            request()->file('fileBuktiKegiatanNama')->storeAs($user->nama_user.'/buktiKegiatan' , $nameFile , ['disk' => 'public']);

        }

        $add = Pengajuan::where('id' , $id)->update([
            'bukti' => $nameFile, 
            'status' => 5, 
        ]);

        $no_admin = User::where('role' , 2)->first();
        $phone = $no_admin->no_hp; // Nomor admin
        $message = "Kegiatan telah selesai dilaksanakan".  
                   "\noleh: " .$user = Auth::user()->nama_user .
                   "\nMohon segera diperiksa".
                   "\nTerima Kasih";

        $response = $this->whatsappService->sendMessage($phone, $message);
        
    }
    public function addPengajuan(Request $request)
    {
        $user = Auth::user();
        $nameFile = request()->file('rpp')->getClientOriginalName();
        $bukti = request()->file('bukti')->getClientOriginalName();

        if(!Storage::disk('public')->exists($user->nama_user)) {
            Storage::disk('public')->makeDirectory($user->nama_user);
        }  
              

        request()->file('rpp')->storeAs($user->nama_user.'/rpp' , $nameFile , ['disk' => 'public']);
        request()->file('bukti')->storeAs($user->nama_user.'/bukti' , $bukti , ['disk' => 'public']);
        
        $add = Pengajuan::create([
            'nama_kegiatan' => request('nama_kegiatan'), 
            'user_id' =>  $user = Auth::user()->id, 
            'catatan' => '', 
            'estimasi' => request('waktu'), 
            'jumlah_poin' => request('jumlah_poin'), 
            'rpp' =>  $nameFile, 
            'bukti' =>  $bukti, 
            'tanggal' =>  Carbon::now(),
            'status' => 2 , 
        ]);

        // Kirim notifikasi WhatsApp ke admin
        $nama_kegiatan = Program::find(request('nama_kegiatan'))->nama_program;
        $no_admin = User::where('role' , 3)->first();
        $phone = $no_admin->no_hp; // Nomor admin
        $message = "Assalamualaikum Wr Wb, Bapak/Ibu.
                     \nDimohon untuk segera melakukan validasi terhadap program kinerja dengan keterangan : 
                    \nNama Kegiatan : " . $nama_kegiatan . 
                   "\nGuru : " .$user = Auth::user()->nama_user .
                   "\Waktu Pelaksanaan : " . request('waktu') . " Semester" .
                   "\nJumlah Poin : " . request('jumlah_poin').
                   "\nMohon segera diperiksa".
                   "\nTerima Kasih";

                   

        $response = $this->whatsappService->sendMessage($phone, $message);
    }

    public function editPengajuan()
    {         
        $name =  request()->file('rpp');
        $bukti =  request()->file('bukti');
        $nama_rpp =  request('rpp_name');

        $pengajuanId = request('id');
        $nama_kegiatan = request('nama_kegiatan');
        $estimasi = request('waktu');
        $jumlah_poin = request('jumlah_poin');
        $user = Auth::user();
        $user_id = $user->id;
        $user_nama = $user->nama_user;

        $data = Pengajuan::find($pengajuanId);

        // Inisialisasi variabel flag perubahan
        $isUpdated = false;

        // Update RPP jika ada
        if (request()->hasFile('rpp')) {
            Storage::disk('public')->delete($user_nama . '/rpp/' . $data->rpp);
            $rppFile = request()->file('rpp');
            $nameFile = $rppFile->getClientOriginalName();
            $rppFile->storeAs($user_nama . '/rpp', $nameFile, ['disk' => 'public']);

            Pengajuan::where('id', $pengajuanId)->update([
                'rpp' => $nameFile,
            ]);

            $isUpdated = true;
        }

        // Update Bukti jika ada
        if (request()->hasFile('bukti')) {
            Storage::disk('public')->delete($user_nama . '/bukti/' . $data->bukti);
            $buktiFile = request()->file('bukti');
            $nama_bukti = $buktiFile->getClientOriginalName();
            $buktiFile->storeAs($user_nama . '/bukti', $nama_bukti, ['disk' => 'public']);

            Pengajuan::where('id', $pengajuanId)->update([
                'bukti' => $nama_bukti,
            ]);

            $isUpdated = true;
        }

        // Update data umum
        Pengajuan::where('id', $pengajuanId)->update([
            'nama_kegiatan' => $nama_kegiatan,
            'user_id' => $user_id,
            'estimasi' => $estimasi,
            'jumlah_poin' => $jumlah_poin,
            'status' => 2,
        ]);

        // Kirim WhatsApp jika ada perubahan file
        if ($isUpdated) {
            $no_admin = User::where('role', 3)->first();
            $phone = $no_admin->no_hp;

            $message = "Assalamu’alaikum Wr. Wb.\n" .
                    "Yth. Bapak/Ibu Kepala Sekolah,\n" .
                    "Perbaikan pengajuan kegiatan sudah selesai.\n" .
                    "Oleh: $user_nama\n\n" .
                    "Mohon kiranya dapat segera diperiksa dan ditindaklanjuti.\n\n" .
                    "Terima kasih.";

            $response = $this->whatsappService->sendMessage($phone, $message);
        }


      

    }
    public function deletePengajuan($id)
    {
      $user = Auth::user();
      $data = Pengajuan::find($id);
      Storage::disk('public')->delete($user->nama_user.'/rpp'.'/'.$data->rpp);
      Storage::disk('public')->delete($user->nama_user.'/bukti'.'/'.$data->bukti);
      $deltete = Pengajuan::where('id' , $id)->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        //
    }
}
