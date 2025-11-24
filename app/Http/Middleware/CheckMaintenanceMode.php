<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isMaintenance = (bool) Setting::get('maintenance', 0);

        // If maintenance mode is on, and a user is logged in
        if ($isMaintenance && Auth::check()) {
            // And the user is a student, and they are not trying to log out
            if (Auth::user()->role === 'mahasiswa' && !$request->routeIs('logout')) {
                // Show the maintenance page.
                // We return a response directly, halting further request processing.
                return response()->view('errors.maintenance', [], 503);
            }
        }

        // For all other cases (maintenance off, not a student, or is a student trying to log out),
        // continue with the request.
        return $next($request);
    }
}