<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\OTPVerificationController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Konser publik
Route::get('/daftar', [UserController::class, 'index'])->name('concerts.list');
Route::get('/search-concerts', [UserController::class, 'search'])->name('concerts.search');

/*
|--------------------------------------------------------------------------
| Tiket & Pembayaran (User Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp.verified'])->group(function () {
    Route::get('/checkout', [TicketController::class, 'showCheckoutForm'])->name('tickets.form');
    Route::post('/tickets/check', [TicketController::class, 'checkTicketAvailability'])->name('tickets.check');
    Route::post('/tickets/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
    Route::get('/my-tickets', [TicketController::class, 'userTickets'])->name('tickets.mine');
    Route::post('/pay-ticket/{id}', [TicketController::class, 'simulatePayment'])->name('tickets.pay');
    Route::get('/tickets/download/{ticket}', [TicketController::class, 'download'])->name('tickets.download');
});

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
// Route::middleware('auth')->group(function () {
//     Route::get('/email/verify', function () {
//         return view('auth.verify-email');
//     })->name('verification.notice');

//     Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//         $request->fulfill();
//         return redirect('/dashboard');
//     })->middleware(['signed'])->name('verification.verify');

//     Route::post('/email/verification-notification', function (Request $request) {
//         $request->user()->sendEmailVerificationNotification();
//         return back()->with('message', 'Verification link sent!');
//     })->middleware('throttle:6,1')->name('verification.send');
// });

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Jetstream + Role)
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {


    Route::get('/verify-otp', [OTPVerificationController::class, 'showForm'])->name('otp.verify.form');
    Route::post('/verify-otp', [OTPVerificationController::class, 'verify'])->name('otp.verify.submit');
    Route::get('/resend-otp', [OTPVerificationController::class, 'resend'])->name('otp.resend');
    
    // Redirect berdasarkan role setelah login
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return match ($user->role) {
            'super_admin' => redirect('/dashboard/super-admin'),
            'admin' => redirect('/admin/concerts'),
            'user' => redirect('/home'),
            default => abort(403),
        };
    });

    // User routes (OTP wajib diverifikasi)
    Route::middleware(['role:user', 'otp.verified'])->group(function () {
        Route::get('/home', [UserController::class, 'index'])->name('user.home');
        Route::get('/daftar-konser', [UserController::class, 'index'])->name('user.konser');
    });

    // Super Admin routes
    Route::middleware('auth', 'role:super_admin')->group(function () {
        // Dashboard Super Admin
        Route::get('/dashboard/super-admin', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

        // CRUD User
        Route::get('/superadmin/users', [SuperAdminController::class, 'index'])->name('superadmin.users.index');
        Route::get('/superadmin/users/create', [SuperAdminController::class, 'create'])->name('superadmin.users.create');
        Route::post('/superadmin/users', [SuperAdminController::class, 'store'])->name('superadmin.users.store');
        Route::get('/superadmin/users/{user}/edit', [SuperAdminController::class, 'edit'])->name('superadmin.users.edit');
        Route::put('/superadmin/users/{user}', [SuperAdminController::class, 'update'])->name('superadmin.users.update');
        Route::delete('/superadmin/users/{user}', [SuperAdminController::class, 'destroy'])->name('superadmin.users.destroy');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/concerts', [AdminController::class, 'index'])->name('dashboard.admin.konser');
        Route::get('/concerts/create', [AdminController::class, 'create'])->name('dashboard.admin.create');
        Route::post('/concerts', [AdminController::class, 'store'])->name('concerts.store');
        Route::get('/concerts/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/concerts/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/concerts/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });
});