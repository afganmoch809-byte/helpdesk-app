<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login, lanjutkan
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        
        // Cek apakah profile sudah lengkap
        $isProfileComplete = !empty($user->gender) && 
                            !empty($user->phone) && 
                            !empty($user->address);

        // Jika profile belum lengkap dan bukan di halaman edit profile
        if (!$isProfileComplete && !$request->routeIs('profile.edit') && !$request->routeIs('profile.update')) {
            return redirect()->route('profile.edit')->with('warning', 'Silakan lengkapi data profil Anda terlebih dahulu.');
        }

        return $next($request);
    }
}