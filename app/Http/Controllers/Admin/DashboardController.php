<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();
        $totalMahasiswa = User::where('role','mahasiswa')->count();
        $totalVerifikator = User::where('role','verifikator')->count();
        $totalPortfolios = Portfolio::count();

        $verified = Portfolio::where('status','verified')->count();
        $rejected = Portfolio::where('status','rejected')->count();
        $pending = Portfolio::where('status','pending')->count();
        
        // Data prestasi per prodi
        $prestasiProdi = Portfolio::where('status', 'verified')
            ->join('users', 'portfolios.user_id', '=', 'users.id')
            ->join('prodis', 'users.prodi_id', '=', 'prodis.id')
            ->select('users.prodi_id', DB::raw('count(*) as total'))
            ->groupBy('users.prodi_id')
            ->with('user.prodi')
            ->get();

        return view('admin.dashboard', compact('totalUsers','totalMahasiswa','totalVerifikator','totalPortfolios','verified','rejected','pending','prestasiProdi'));
    }
}

