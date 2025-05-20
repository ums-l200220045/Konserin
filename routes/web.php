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


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/daftar', [UserController::class, 'index'])->name('concerts.list');
Route::get('/search-concerts', [UserController::class, 'search'])->name('concerts.search');


Route::get('/checkout', [TicketController::class, 'showCheckoutForm'])->name('tickets.form');
Route::middleware(['auth', 'verified'])->post('/tickets/check', [TicketController::class, 'checkTicketAvailability'])->name('tickets.check');
Route::post('/tickets/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
Route::middleware(['auth', 'verified'])->get('/my-tickets', [TicketController::class, 'userTickets'])->name('tickets.mine');
Route::middleware(['auth', 'verified'])->post('/pay-ticket/{id}', [TicketController::class, 'simulatePayment'])->name('tickets.pay');

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
            'admin' => redirect('/admin/concerts'),
            'user' => redirect('/home'),
            default => abort(403),
        };
    });
    Route::middleware('role:user')->get('/daftar-konser', [UserController::class, 'index']);
    Route::middleware('role:super_admin')->get('/dashboard/super-admin', [SuperAdminController::class, 'index']);
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/concerts', [AdminController::class, 'index'])->name('dashboard.admin.konser');
        Route::get('/concerts/create', [AdminController::class, 'create'])->name('dashboard.admin.create');
        Route::post('/concerts', [AdminController::class, 'store'])->name('concerts.store');
        Route::get('/concerts/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/concerts/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/concerts/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });
    Route::middleware('role:user', 'verified')->get('/home', [UserController::class, 'index']);
});