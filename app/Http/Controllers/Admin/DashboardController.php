<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $prestasiProdi = Portfolio::where('portfolios.status', 'verified')
            ->join('users', 'portfolios.user_id', '=', 'users.id')
            ->join('prodis', 'users.prodi_id', '=', 'prodis.id')
            ->select('prodis.nama_prodi', DB::raw('count(*) as total'))
            ->groupBy('prodis.nama_prodi')
            ->orderBy('total', 'desc')
            ->get();

        // Data untuk Grafik Tren Pengajuan
        $startDate = Carbon::now()->subDays(29);
        $endDate = Carbon::now();
        
        $portfolioCounts = Portfolio::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('count', 'date');

        $portfolioTrend = collect(range(0, 29))->map(function ($i) use ($startDate, $portfolioCounts) {
            $date = $startDate->copy()->addDays($i);
            return [
                'x' => $date->format('M d'),
                'y' => $portfolioCounts->get($date->format('Y-m-d'), 0),
            ];
        });

        // Data untuk Statistik Perbandingan Bulan
        $currentMonthSubmissions = Portfolio::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $previousMonthSubmissions = Portfolio::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $delta = 0;
        if ($previousMonthSubmissions > 0) {
            $delta = round((($currentMonthSubmissions - $previousMonthSubmissions) / $previousMonthSubmissions) * 100);
        } elseif ($currentMonthSubmissions > 0) {
            $delta = 100;
        }

        $currentMonth = [
            'value' => $currentMonthSubmissions,
        ];

        // Data untuk Donut Chart Status
        $statusDonut = [
            ['label' => 'Verified', 'value' => $verified, 'color' => '#10B981'],
            ['label' => 'Rejected', 'value' => $rejected, 'color' => '#F43F5E'],
            ['label' => 'Pending', 'value' => $pending, 'color' => '#F59E0B'],
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMahasiswa',
            'totalVerifikator',
            'totalPortfolios',
            'verified',
            'rejected',
            'pending',
            'prestasiProdi',
            'portfolioTrend',
            'currentMonth',
            'delta',
            'statusDonut'
        ));
    }
}

