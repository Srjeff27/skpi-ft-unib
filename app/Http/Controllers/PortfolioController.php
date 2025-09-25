<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $portfolios = Auth::user()
            ->portfolios()
            ->latest()
            ->paginate(10);

        return view('student.portfolios.index', compact('portfolios'));
    }

    public function create(): View
    {
        return view('student.portfolios.create');
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $portfolio = Auth::user()->portfolios()->create([
            'kategori_portfolio' => $request->kategori_portfolio,
            'judul_kegiatan' => $request->judul_kegiatan,
            'penyelenggara' => $request->penyelenggara,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'nama_dokumen_id' => $request->nama_dokumen_id,
            'nama_dokumen_en' => $request->nama_dokumen_en,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'link_sertifikat' => $request->link_sertifikat,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('student.portfolios.index')
            ->with('success', 'Portfolio berhasil disimpan dan menunggu verifikasi.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $this->authorize('update', $portfolio);
        return view('student.portfolios.create', compact('portfolio'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->authorize('update', $portfolio);

        $portfolio->update([
            'kategori_portfolio' => $request->kategori_portfolio,
            'judul_kegiatan' => $request->judul_kegiatan,
            'penyelenggara' => $request->penyelenggara,
            'nomor_dokumen' => $request->nomor_dokumen,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'nama_dokumen_id' => $request->nama_dokumen_id,
            'nama_dokumen_en' => $request->nama_dokumen_en,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'link_sertifikat' => $request->link_sertifikat,
            'status' => 'pending', // Reset to pending when updated
        ]);

        return redirect()
            ->route('student.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui dan menunggu verifikasi ulang.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->authorize('delete', $portfolio);
        
        $portfolio->delete();

        return redirect()
            ->route('student.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }
}
