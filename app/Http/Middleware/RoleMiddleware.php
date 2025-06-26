<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $requiredRole): Response
    { 
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        // Jika role tidak sesuai dengan yang diminta route
        if ($userRole !== $requiredRole) {
            switch ($userRole) {
                case 'user':
                    return redirect('/user/')->with('error', 'Akun Anda adalah user biasa. Anda tidak memiliki izin untuk mengakses halaman ini.');
                case 'admin':
                    return redirect('/admin/dashboard')->with('error', 'Anda adalah admin, tapi tidak diizinkan mengakses halaman ini.');
                default:
                    return redirect('/')->with('error', 'Role Anda tidak dikenali. Akses ditolak.');
            }
        }

        return $next($request);
    }
}
