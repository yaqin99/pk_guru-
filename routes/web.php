<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\PengajuanController;
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
Route::get('/login', [UserController::class,'login']);


//guru All Routes

Route::get('/guru', [GuruController::class,'index']);
Route::get('/getGuru', [GuruController::class,'getGuru']);
Route::post('/addGuru', [GuruController::class,'addGuru']);
Route::get('/deleteGuru/{id}', [GuruController::class,'deleteGuru']);
Route::put('/editGuru', [GuruController::class,'editGuru']);

//Pengajuan All Routes

Route::get('/pengajuan', [PengajuanController::class,'index']);
Route::get('/getPengajuan', [PengajuanController::class,'getPengajuan']);
Route::post('/addPengajuan', [PengajuanController::class,'addPengajuan']);
