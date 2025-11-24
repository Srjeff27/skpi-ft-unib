<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAcademicDataComplete
{
    /**
    * Pastikan mahasiswa telah melengkapi data akademik sebelum melanjutkan.
    */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'mahasiswa' && !$user->isAcademicProfileComplete()) {
            if ($request->routeIs('profile.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('profile.edit')->with('academic_incomplete', true);
        }

        return $next($request);
    }
}
