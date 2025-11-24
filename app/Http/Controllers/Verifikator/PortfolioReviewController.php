<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Notifications\PortfolioStatusNotification;
use App\Services\ActivityLogger;

class PortfolioReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = Portfolio::query()->with(['user.prodi']);

        if ($request->filled('prodi_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('prodi_id', $request->integer('prodi_id'));
            });
        }

        if ($request->filled('angkatan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('angkatan', $request->integer('angkatan'));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $portfolios = $query->latest()->paginate(15)->withQueryString();

        $prodis = \App\Models\Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        $angkatanList = User::whereNotNull('angkatan')->distinct()->orderBy('angkatan')->pluck('angkatan');

        return view('verifikator.portfolios.index', compact('portfolios','prodis','angkatanList'));
    }

    public function show(Portfolio $portfolio): View
    {
        $portfolio->load(['user.prodi','verifikator']);
        return view('verifikator.portfolios.show', compact('portfolio'));
    }

    public function approve(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $portfolio->update([
            'status' => 'verified',
            'catatan_verifikator' => $request->string('catatan')->toString() ?: null,
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);
        $portfolio->user->notify(new PortfolioStatusNotification($portfolio, 'verified', $request->string('catatan')->toString() ?: null));
        ActivityLogger::log($request->user(), 'verifikator.portfolios.approve', $portfolio, [ 'catatan' => $request->string('catatan')->toString() ]);
        return back()->with('status', 'Portofolio disetujui.');
    }

    public function reject(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $request->validate(['alasan' => ['required','string','max:1000']]);
        $portfolio->update([
            'status' => 'rejected',
            'catatan_verifikator' => $request->string('alasan')->toString(),
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);
        $portfolio->user->notify(new PortfolioStatusNotification($portfolio, 'rejected', $request->string('alasan')->toString()));
        ActivityLogger::log($request->user(), 'verifikator.portfolios.reject', $portfolio, [ 'alasan' => $request->string('alasan')->toString() ]);
        return back()->with('status', 'Portofolio ditolak.');
    }

    public function requestEdit(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $request->validate(['catatan' => ['required','string','max:1000']]);

        $portfolio->update([
            'status' => 'pending',
            'catatan_verifikator' => $request->string('catatan')->toString(),
            'verified_by' => null,
            'verified_at' => null,
        ]);
        $portfolio->user->notify(new PortfolioStatusNotification($portfolio, 'pending', $request->string('catatan')->toString()));
        ActivityLogger::log($request->user(), 'verifikator.portfolios.request_edit', $portfolio, [ 'catatan' => $request->string('catatan')->toString() ]);
        return back()->with('status', 'Diminta perbaikan kepada mahasiswa.');
    }
}
