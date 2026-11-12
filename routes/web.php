<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\HasilAdminController;


Route::get('/', function () {
    return view('Auth/sign-up');
});

Route::middleware(['guest'])->group(function(){

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/post_register', [RegisterController::class, 'store'])->name('post_register');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/post_login', [AuthController::class, 'store'])->name('post_login');


});

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::get('/materi', [MateriController::class, 'index'])->name('materi');
    Route::get('/lengkapi_profil',[ProfilController::class,'create'])->name('lengkapi_profil');
    Route::post('/simpan_profil',[ProfilController::class,'store'])->name('simpan_profil');

    Route::get('/pretest',  [TesController::class, 'form'])->defaults('tipe', 'pretest')->name('pretest');
    Route::post('/pretest', [TesController::class, 'store'])->defaults('tipe', 'pretest')->name('pretest.simpan');
    Route::get('/post_test',  [TesController::class, 'form'])->defaults('tipe', 'posttest')->name('posttest');
    Route::post('/post_test', [TesController::class, 'store'])->defaults('tipe', 'posttest')->name('posttest.simpan');
    Route::get('/hasil_tes/{tipe}', [TesController::class, 'hasil'])
        ->whereIn('tipe', ['pretest', 'posttest'])->name('hasil_tes');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');
});

Route::middleware('role:Admin,Peneliti')->group(function () {
    Route::get('/lihat_hasil', [HasilAdminController::class, 'index'])->name('lihat_hasil');
    Route::get('/lihat_hasil/{hasil}', [HasilAdminController::class, 'detail'])->name('lihat_hasil.detail');
    Route::get('/lihat_hasil/{hasil}/pdf', [HasilAdminController::class, 'pdf'])->name('lihat_hasil.pdf');
    Route::get('/lihat_hasil/{hasil}/excel', [HasilAdminController::class, 'csv'])->name('lihat_hasil.excel');
    });
