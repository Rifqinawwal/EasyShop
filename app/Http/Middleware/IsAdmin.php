<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN merupakan seorang admin
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request); // Jika ya, izinkan akses
        }

        // Jika tidak, tolak akses
        abort(403, 'HANYA ADMIN YANG BOLEH MENGAKSES HALAMAN INI.');
    }
}
