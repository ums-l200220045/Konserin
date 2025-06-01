<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OTPVerificationController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();

        // Jika user sudah verified OTP, redirect langsung
        if ($user->otp_verified) {
            return redirect()->intended('/dashboard');
        }

        return view('auth.verify-otp', ['otp_code' => $user->otp_code]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('otp.verify.form')->withErrors(['otp' => 'User tidak ditemukan.']);
        }

        // Cek OTP dan masa berlaku
        if ($request->otp == $user->otp_code && now()->lessThanOrEqualTo($user->otp_expires_at)) {
            $user->otp_verified = true;
            $user->otp_code = null; // Hapus kode OTP setelah terverifikasi
            $user->otp_expires_at = null;
            $user->save();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
    }

    public function resend()
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('otp.verify.form')->withErrors(['otp' => 'User tidak ditemukan.']);
        }

        // Generate OTP baru
        $user->otp_code = rand(100000, 999999);
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        return redirect()->route('otp.verify.form')->with('message', 'Kode OTP baru telah dikirim.');
    }
}