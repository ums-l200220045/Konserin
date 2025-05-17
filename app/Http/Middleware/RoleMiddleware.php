<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
            // Redirect fallback ke dashboard sesuai peran
            $redirect = match (Auth::user()->role) {
                'super_admin' => '/dashboard/super-admin',
                'admin' => '/dashboard/admin/konser',
                'user' => '/home',
                default => '/',
            };

            return redirect($redirect)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
