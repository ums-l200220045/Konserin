<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(Auth::id());

        if ($user && $user->role === 'user' && !$user->otp_verified) {
            // Generate OTP jika belum ada atau expired
            if (!$user->otp_code || Carbon::now()->greaterThan($user->otp_expires_at)) {
                $user->otp_code = rand(100000, 999999);
                $user->otp_expires_at = Carbon::now()->addMinutes(5); // expired 5 menit
                $user->save();
            }

            // Jika request bukan ke verify OTP, redirect ke form OTP
            if (!$request->is('verify-otp') && !$request->is('logout')) {
                return redirect()->route('otp.verify.form');
            }
        }

        return $next($request);
    }
}