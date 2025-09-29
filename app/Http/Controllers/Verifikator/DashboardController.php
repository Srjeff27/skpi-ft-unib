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
        $pending = Portfolio::where('status','pending')->count();
        $verified = Portfolio::where('status','verified')->count();
        $rejected = Portfolio::where('status','rejected')->count();

        $byProdi = User::selectRaw('prodi_id, COUNT(*) as total')
            ->whereNotNull('prodi_id')
            ->groupBy('prodi_id')
            ->with('prodi:id,nama_prodi')
            ->get();
            
        // Data untuk grafik prestasi per prodi
        $prestasiProdi = Portfolio::join('users', 'portfolios.user_id', '=', 'users.id')
            ->where('portfolios.status', 'verified')
            ->select('users.prodi_id', DB::raw('COUNT(*) as total'))
            ->groupBy('users.prodi_id')
            ->with('user.prodi:id,nama_prodi')
            ->get();

        return view('verifikator.dashboard', compact('pending', 'verified', 'rejected', 'byProdi', 'prestasiProdi'));
    }
}

