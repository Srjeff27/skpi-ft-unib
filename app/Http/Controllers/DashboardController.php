<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Menggunakan `request()->user()` adalah alternatif yang lebih singkat dari `Auth::user()`
        $user = Auth::user();

        if (! $user) {
            // This case is unlikely due to 'auth' middleware, but good practice.
            return redirect()->route('login');
        }

        // Menggunakan switch lebih rapi untuk memeriksa satu variabel dengan banyak kemungkinan nilai.
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'verifikator':
                return redirect()->route('verifikator.dashboard');
            case 'mahasiswa':
                return view('dashboard');
            default:
                // Menangani peran yang tidak terduga untuk mencegah bug di masa depan.
                // Anda bisa logout pengguna dan redirect ke login dengan pesan error.
                Auth::logout();
                return redirect()->route('login')->with('error', 'Peran pengguna tidak valid.');
        }
    }
}
