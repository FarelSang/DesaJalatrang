<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KomentarController;

Route::get('/', function () {
    return redirect()->route('berita.index');
});

Route::resource('berita', BeritaController::class)
    ->parameters(['berita' => 'berita']);


Route::get('captcha', [KomentarController::class, 'captcha'])->name('captcha');
Route::post('berita/{berita}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
