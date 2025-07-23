<?php

use App\Http\Controllers\AspekController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KepribadianController;
use App\Http\Controllers\PedagogikController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\SosialController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//penilaian guru
Route::get('/penilaian', [SiswaController::class,'penilaian'])->middleware('guest');
Route::post('/penilaianMethod', [SiswaController::class, 'penilaianMethod']);
Route::get('/get-guru-by-mapel-kelas', [SiswaController::class, 'getGuruByMapelKelas']);
Route::post('/cekPenilaianAspek', [SiswaController::class, 'cekPenilaianAspek']);

Route::post('/getKomponen', [SiswaController::class,'getKomponen']);
Route::post('/openPenilaian', [SiswaController::class,'openPenilaian']);

//Authentication
Route::get('/login', [UserController::class,'login'])->name('login')->middleware('guest');
Route::post('/loginMethod', [UserController::class,'loginMethod']);
Route::get('/logout', [UserController::class,'logout']);




//Profi
Route::get('/admin/profile/{id}', [UserController::class,'profile']);
Route::post('/admin/profile/update', [UserController::class,'updateProfile']);
Route::post('/admin/guru/reset-poin', [GuruController::class,'resetPoin']);

//guru All Routes
Route::get('/', [PengajuanController::class,'index'])->middleware('auth');
Route::get('/guru', [GuruController::class,'index'])->middleware('auth');
Route::get('/getGuru', [GuruController::class,'getGuru'])->middleware('auth');
Route::post('/addGuru', [GuruController::class,'addGuru']);
Route::get('/deleteGuru/{id}', [GuruController::class,'deleteGuru']);
Route::put('/editGuru', [GuruController::class,'editGuru']);
Route::get('/guru/aspek/{id}', [GuruController::class,'getAspek']);
Route::get('/guru/nilaiAspek/{id}', [GuruController::class,'getNilaiAspek']);
Route::get('/guru/download/{id}/{dokumen}/{type}', [GuruController::class,'download']);
//Pengajuan All Routes


//siswa 
Route::get('/siswa', [SiswaController::class,'index'])->middleware('auth');
Route::get('/siswa/cek-absen-terakhir', [SiswaController::class, 'cekAbsenTerakhir']);
Route::post('/siswa/addSiswa', [SiswaController::class,'addSiswa'])->middleware('auth');
Route::get('/siswa/getSiswa/{id}', [SiswaController::class, 'getSiswa'])->middleware('auth');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'deleteSiswa'])->middleware('auth');
Route::post('/siswa/ubah-status', [SiswaController::class, 'ubahStatus'])->middleware('auth');
Route::post('/siswa/kirim-wa-semua', [SiswaController::class, 'kirimWaSemua'])->name('siswa.kirimWa')->middleware('auth');
Route::get('/siswa/kirimWa/{id}', [SiswaController::class, 'kirimWa']);

Route::get('/siswa/cek-status', function (Request $request) {
    $siswa = \App\Models\Siswa::find($request->id);
    if (!$siswa) {
        return response()->json(['success' => false], 404);
    }
    return response()->json(['status' => $siswa->status]);
});


Route::get('/pengajuan', [PengajuanController::class,'index'])->middleware('auth');
Route::post('/pengajuan/approve', [PengajuanController::class,'approve'])->middleware('auth');
Route::post('/pengajuan/tolak', [PengajuanController::class,'tolak'])->middleware('auth');
Route::post('/pengajuan/catatan', [PengajuanController::class,'catatan'])->middleware('auth');
Route::post('/pengajuan/perbaiki', [PengajuanController::class,'perbaiki'])->middleware('auth');
Route::get('/getPengajuan', [PengajuanController::class,'getPengajuan'])->middleware('auth');
Route::post('/addPengajuan', [PengajuanController::class,'addPengajuan']);
Route::post('/pengajuan/addBuktiKegiatan', [PengajuanController::class,'addBuktiKegiatan']);
Route::post('/editPengajuan', [PengajuanController::class,'editPengajuan']);
Route::get('/deletePengajuan/{id}', [PengajuanController::class,'deletePengajuan']);
Route::post('/getSingleProgram', [PengajuanController::class,'getSingleProgram']);
Route::post('/sendToKepsek', [PengajuanController::class,'sendToKepsek']);
Route::post('/adminValidasi', [PengajuanController::class,'adminValidasi']);
Route::post('/kepsekValidasi', [PengajuanController::class,'kepsekValidasi']);


// Data Surat pengajuan dan teguran
Route::post('/surat/cekGuru', [SuratController::class,'cekGuru'])->middleware('auth');
Route::get('/surat', [SuratController::class,'index'])->middleware('auth');
Route::get('/surat/suratKinerja', [SuratController::class,'suratKinerja'])->middleware('auth');
Route::post('/surat/cetakSurat', [SuratController::class,'cetak'])->middleware('auth');
Route::get('/surat/cetakSurat/getVersion/{data}', [SuratController::class,'cetakGet'])->middleware('auth');
Route::post('/surat/approve', [SuratController::class,'approve'])->middleware('auth');
Route::post('/addSurat', [SuratController::class,'addSurat']);
Route::post('/editSurat', [SuratController::class,'editSurat']);
Route::get('/deleteSurat/{id}', [SuratController::class,'deleteSurat']);
Route::post('/surat/teruskanSurat', [SuratController::class,'teruskanSurat'])->middleware('auth');
Route::post('/surat/tolak', [SuratController::class,'tolak'])->middleware('auth');



Route::post('/guru/aspek/cekAspek', [GuruController::class,'cekAspek']);
Route::post('/guru/aspek/nilai', [GuruController::class,'nilai']);
Route::post('/guru/aspek/store', [GuruController::class,'storeAspek']);
Route::post('/guru/aspek/edit', [GuruController::class,'editAspek']);
Route::post('/guru/aspek/delete', [GuruController::class,'deleteAspek']);
//pegagogik
Route::get('/aspek/pedagogik', [PedagogikController::class,'index'])->middleware('auth');
Route::post('/aspek/pedagogik/addPedagogik', [PedagogikController::class,'addPedagogik']);
Route::post('/aspek/pedagogik/editPedagogik', [PedagogikController::class,'editPedagogik']);
Route::get('/aspek/pedagogik/deletePedagogik/{id}', [PedagogikController::class,'deletePedagogik']);

//kepribadian
Route::get('/aspek/kepribadian', [KepribadianController::class,'index'])->middleware('auth');
Route::post('/aspek/kepribadian/addKepribadian', [KepribadianController::class,'addKepribadian']);
Route::post('/aspek/kepribadian/editKepribadian', [KepribadianController::class,'editKepribadian']);
Route::get('/aspek/kepribadian/deleteKepribadian/{id}', [KepribadianController::class,'deleteKepribadian']);

//profesional
Route::get('/aspek/profesional', [ProfesionalController::class,'index'])->middleware('auth');
Route::post('/aspek/profesional/addProfesional', [ProfesionalController::class,'addProfesional']);
Route::post('/aspek/profesional/editProfesional', [ProfesionalController::class,'editProfesional']);
Route::get('/aspek/profesional/deleteProfesional/{id}', [ProfesionalController::class,'deleteProfesional']);

//sosial
Route::get('/aspek/sosial', [SosialController::class,'index'])->middleware('auth');
Route::post('/aspek/sosial/addSosial', [SosialController::class,'addSosial']);
Route::post('/aspek/sosial/editSosial', [SosialController::class,'editSosial']);
Route::get('/aspek/sosial/deleteSosial/{id}', [SosialController::class,'deleteSosial']);

//aspek

Route::get('/aspek', [AspekController::class,'index'])->middleware('auth');
Route::post('/aspek/getAspek', [AspekController::class,'getAspek']);
Route::post('/aspek/editAspek', [AspekController::class,'editAspek']);
Route::get('/aspek/deleteAspek/{id}', [AspekController::class,'deleteAspek']);


Route::get('/program', [ProgramController::class,'index'])->middleware('auth');
Route::post('/addProgram', [ProgramController::class,'addProgram']);
Route::post('/editProgram', [ProgramController::class,'editProgram']);
Route::get('/deleteProgram/{id}', [ProgramController::class,'deleteProgram']);