<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StorePortfolioRequest;
use App\Http\Requests\Student\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Throwable;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $portfolios = Portfolio::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('student.portfolios.index', compact('portfolios'));
    }

    public function create(): View
    {
        $categories = \App\Models\PortfolioCategory::orderBy('name')->pluck('name');
        return view('student.portfolios.create', compact('categories'));
    }

    public function store(StorePortfolioRequest $request, PortfolioService $portfolioService): RedirectResponse
    {
        try {
            $portfolioService->createForUser($request->user(), $request->validated(), $request->file('bukti_file'));
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan portofolio', [
                'user_id' => $request->user()->id,
                'payload' => $request->except(['bukti_file', '_token']),
                'error' => $e->getMessage(),
            ]);

            return back()->withInput()->withErrors([
                'general' => 'Gagal menyimpan portofolio. Silakan cek kembali isian Anda atau hubungi admin.',
            ]);
        }

        return redirect()->route('student.portfolios.index')->with('status', 'Portofolio berhasil ditambahkan.');
    }

    public function edit($id): View
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Debug: Log informasi portfolio dan user
        \Log::info('Edit Portfolio Debug', [
            'portfolio_id' => $portfolio->id,
            'portfolio_user_id' => $portfolio->user_id,
            'auth_user_id' => auth()->id(),
            'auth_user_role' => auth()->user()->role ?? 'not_logged_in'
        ]);
        
        abort_unless($portfolio->user_id === auth()->id(), 403);
        
        $categories = \App\Models\PortfolioCategory::orderBy('name')->pluck('name');
        return view('student.portfolios.edit', compact('portfolio','categories'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio, PortfolioService $portfolioService): RedirectResponse
    {
        abort_unless($portfolio->user_id === auth()->id(), 403);

        if ($portfolio->status !== 'pending') {
            return back()->with('status', 'Portofolio sudah diverifikasi, tidak dapat diedit.');
        }

        $portfolioService->updateForUser($portfolio, $request->validated(), $request->file('bukti_file'));

        return redirect()->route('student.portfolios.index')->with('status', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        abort_unless($portfolio->user_id === auth()->id(), 403);

        // Menghapus batasan status, mahasiswa dapat menghapus portofolio apapun statusnya
        $portfolio->delete();
        return redirect()->route('student.portfolios.index')->with('status', 'Portofolio berhasil dihapus.');
    }
}
