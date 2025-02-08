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
use Illuminate\Support\Facades\Route;

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


//Authentication
Route::get('/login', [UserController::class,'login'])->name('login')->middleware('guest');
Route::post('/loginMethod', [UserController::class,'loginMethod']);
Route::get('/logout', [UserController::class,'logout']);


//guru All Routes

Route::get('/', [PengajuanController::class,'index'])->middleware('auth');
Route::get('/guru', [GuruController::class,'index'])->middleware('auth');
Route::get('/getGuru', [GuruController::class,'getGuru'])->middleware('auth');
Route::post('/addGuru', [GuruController::class,'addGuru']);
Route::get('/deleteGuru/{id}', [GuruController::class,'deleteGuru']);
Route::put('/editGuru', [GuruController::class,'editGuru']);

//Pengajuan All Routes

Route::get('/pengajuan', [PengajuanController::class,'index'])->middleware('auth');
Route::post('/pengajuan/approve', [PengajuanController::class,'approve'])->middleware('auth');
Route::post('/pengajuan/tolak', [PengajuanController::class,'tolak'])->middleware('auth');
Route::post('/pengajuan/catatan', [PengajuanController::class,'catatan'])->middleware('auth');
Route::get('/getPengajuan', [PengajuanController::class,'getPengajuan'])->middleware('auth');
Route::post('/addPengajuan', [PengajuanController::class,'addPengajuan']);
Route::post('/pengajuan/addBuktiKegiatan', [PengajuanController::class,'addBuktiKegiatan']);
Route::post('/editPengajuan', [PengajuanController::class,'editPengajuan']);
Route::get('/deletePengajuan/{id}', [PengajuanController::class,'deletePengajuan']);
Route::post('/getSingleProgram', [PengajuanController::class,'getSingleProgram']);
Route::post('/sendToKepsek', [PengajuanController::class,'sendToKepsek']);
Route::post('/adminValidasi', [PengajuanController::class,'adminValidasi']);


// Data Surat pengajuan dan teguran
Route::get('/surat', [SuratController::class,'index'])->middleware('auth');
Route::post('/surat/cetakSurat', [SuratController::class,'cetak'])->middleware('auth');
Route::get('/surat/cetakSurat/getVersion/{data}', [SuratController::class,'cetakGet'])->middleware('auth');
Route::post('/surat/approve', [SuratController::class,'approve'])->middleware('auth');
Route::post('/addSurat', [SuratController::class,'addSurat']);
Route::post('/editSurat', [SuratController::class,'editSurat']);
Route::get('/deleteSurat/{id}', [SuratController::class,'deleteSurat']);


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
Route::get('/aspek/getAspek/{id}', [AspekController::class,'getAspek']);
Route::post('/aspek/editAspek', [AspekController::class,'editAspek']);
Route::get('/aspek/deleteAspek/{id}', [AspekController::class,'deleteAspek']);


Route::get('/program', [ProgramController::class,'index'])->middleware('auth');
Route::post('/addProgram', [ProgramController::class,'addProgram']);
Route::post('/editProgram', [ProgramController::class,'editProgram']);
Route::get('/deleteProgram/{id}', [ProgramController::class,'deleteProgram']);