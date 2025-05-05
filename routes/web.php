<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('homeutama');
});

Route::get('/daftar', function () {
    return view('daftarkonser');
});

Route::get('/detail', function () {
    return view('detailkonser');
});

Route::get('/co', function () {
    return view('checkout');
});

Route::get('/regis', function () {
    return view('formregis');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
