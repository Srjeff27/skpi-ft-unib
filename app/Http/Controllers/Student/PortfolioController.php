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
        return view('student.portfolios.create');
    }

    public function store(StorePortfolioRequest $request, PortfolioService $portfolioService): RedirectResponse
    {
        $portfolioService->createForUser($request->user(), $request->validated(), $request->file('bukti_file'));

        return redirect()->route('student.portfolios.index')->with('status', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio): View
    {
        abort_unless($portfolio->user_id === auth()->id(), 403);

        return view('student.portfolios.edit', compact('portfolio'));
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

        if ($portfolio->status !== 'pending') {
            return back()->with('status', 'Portofolio sudah diverifikasi, tidak dapat dihapus.');
        }

        $portfolio->delete();
        return redirect()->route('student.portfolios.index')->with('status', 'Portofolio berhasil dihapus.');
    }
}
