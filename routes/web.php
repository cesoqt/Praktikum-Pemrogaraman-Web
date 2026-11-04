<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::get('/', function () {
    return view('welcome');
});

// route untuk daftar buku dan pencarian
Route::get('/buku', [BukuController::class, 'index']);

// route untuk detail buku berdasarkan parameter kode
Route::get('/buku/{kode}', [BukuController::class, 'show']);