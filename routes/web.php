<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\PedagogikController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
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

Route::get('/', [GuruController::class,'index'])->middleware('auth');
Route::get('/guru', [GuruController::class,'index'])->middleware('auth');
Route::get('/getGuru', [GuruController::class,'getGuru'])->middleware('auth');
Route::post('/addGuru', [GuruController::class,'addGuru']);
Route::get('/deleteGuru/{id}', [GuruController::class,'deleteGuru']);
Route::put('/editGuru', [GuruController::class,'editGuru']);

//Pengajuan All Routes

Route::get('/pengajuan', [PengajuanController::class,'index'])->middleware('auth');
Route::get('/getPengajuan', [PengajuanController::class,'getPengajuan'])->middleware('auth');
Route::post('/addPengajuan', [PengajuanController::class,'addPengajuan']);
Route::post('/editPengajuan', [PengajuanController::class,'editPengajuan']);
Route::get('/deletePengajuan/{id}', [PengajuanController::class,'deletePengajuan']);


// Data Surat pengajuan dan teguran
Route::get('/surat', [SuratController::class,'index'])->middleware('auth');
Route::post('/addSurat', [SuratController::class,'addSurat']);
Route::post('/editSurat', [SuratController::class,'editSurat']);
Route::get('/deleteSurat/{id}', [SuratController::class,'deleteSurat']);


//pegagogik
Route::get('/aspek/pedagogik', [PedagogikController::class,'index'])->middleware('auth');
Route::post('/aspek/pedagogik/addPedagogik', [PedagogikController::class,'addPedagogik']);
Route::post('/aspek/pedagogik/editPedagogik', [PedagogikController::class,'editPedagogik']);
Route::get('/aspek/pedagogik/deletePedagogik{id}', [PedagogikController::class,'deletePedagogik']);
