<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kategori' => ['required','string','max:255'],
            'tingkat' => ['nullable','in:regional,nasional,internasional'],
            'judul_kegiatan' => ['required','string','max:255'],
            'penyelenggara' => ['required','string','max:255'],
            'tanggal_mulai' => ['required','date'],
            'tanggal_selesai' => ['nullable','date','after_or_equal:tanggal_mulai'],
            'deskripsi_kegiatan' => ['nullable','string'],
            'bukti_link' => ['nullable','url','max:255'],
            'bukti_file' => ['nullable','file','mimetypes:application/pdf,image/jpeg,image/png,image/webp','max:2048'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';

        if ($request->hasFile('bukti_file')) {
            $path = $request->file('bukti_file')->store('certificates', 'public');
            $data['bukti_link'] = asset('storage/'.$path);
            unset($data['bukti_file']);
        }

        Portfolio::create($data);

        return redirect()->route('student.portfolios.index')->with('status', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio): View
    {
        abort_unless($portfolio->user_id === auth()->id(), 403);

        return view('student.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        abort_unless($portfolio->user_id === auth()->id(), 403);

        if ($portfolio->status !== 'pending') {
            return back()->with('status', 'Portofolio sudah diverifikasi, tidak dapat diedit.');
        }

        $data = $request->validate([
            'kategori' => ['required','string','max:255'],
            'tingkat' => ['nullable','in:regional,nasional,internasional'],
            'judul_kegiatan' => ['required','string','max:255'],
            'penyelenggara' => ['required','string','max:255'],
            'tanggal_mulai' => ['required','date'],
            'tanggal_selesai' => ['nullable','date','after_or_equal:tanggal_mulai'],
            'deskripsi_kegiatan' => ['nullable','string'],
            'bukti_link' => ['nullable','url','max:255'],
            'bukti_file' => ['nullable','file','mimetypes:application/pdf,image/jpeg,image/png,image/webp','max:2048'],
        ]);

        if ($request->hasFile('bukti_file')) {
            $path = $request->file('bukti_file')->store('certificates', 'public');
            $data['bukti_link'] = asset('storage/'.$path);
            unset($data['bukti_file']);
        }

        $portfolio->update($data);

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
