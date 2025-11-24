<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $prodiId = $user->prodi_id;

        // Scope portfolio counts to the verifier's prodi
        $pending = Portfolio::where('status', 'pending')
            ->whereHas('user', fn($q) => $q->where('prodi_id', $prodiId))
            ->count();
        $verified = Portfolio::where('status', 'verified')
            ->whereHas('user', fn($q) => $q->where('prodi_id', $prodiId))
            ->count();
        $totalStudents = User::where('role', 'mahasiswa')
            ->where('prodi_id', $prodiId)
            ->count();
        
        // Get recent pending portfolios for the verifier's prodi
        $recentPending = Portfolio::with('user')
            ->where('status', 'pending')
            ->whereHas('user', fn($q) => $q->where('prodi_id', $prodiId))
            ->latest()
            ->take(5)
            ->get();

        return view('verifikator.dashboard', compact('pending', 'verified', 'totalStudents', 'recentPending'));
    }
}

