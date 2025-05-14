<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('homeutama');
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    // Redirect berdasarkan role setelah login
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match ($user->role) {
            'super_admin' => redirect('/dashboard/super-admin'),
            'admin' => redirect('/dashboard/admin'),
            'user' => redirect('/home'),
            default => abort(403),
        };
    });

    Route::middleware('role:super_admin')->get('/dashboard/super-admin', [SuperAdminController::class, 'index']);
    Route::middleware('role:admin')->get('/dashboard/admin', [AdminController::class, 'index']);
    Route::middleware('role:user', 'verified')->get('/home', [UserController::class, 'index']);
});