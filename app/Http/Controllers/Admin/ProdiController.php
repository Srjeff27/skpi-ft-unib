<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\ActivityLogger;

class ProdiController extends Controller
{
    public function index(): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->paginate(20);
        return view('admin.prodis.index', compact('prodis'));
    }

    public function create(): View
    {
        return view('admin.prodis.form', ['prodi' => new Prodi()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_prodi' => ['required','string','max:255'],
            'jenjang' => ['required','string','max:50'],
        ]);
        Prodi::create($data);
        ActivityLogger::log($request->user(), 'admin.prodis.store');
        return redirect()->route('admin.prodis.index')->with('status','Prodi ditambahkan');
    }

    public function edit(Prodi $prodi): View
    {
        return view('admin.prodis.form', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi): RedirectResponse
    {
        $data = $request->validate([
            'nama_prodi' => ['required','string','max:255'],
            'jenjang' => ['required','string','max:50'],
        ]);
        $prodi->update($data);
        ActivityLogger::log($request->user(), 'admin.prodis.update', $prodi);
        return redirect()->route('admin.prodis.index')->with('status','Prodi diperbarui');
    }

    public function destroy(Request $request, Prodi $prodi): RedirectResponse
    {
        if ($prodi->users()->exists()) {
            return back()->with('error', 'Prodi tidak dapat dihapus karena masih memiliki user (mahasiswa/verifikator).');
        }
        $prodi->delete();
        ActivityLogger::log($request->user(), 'admin.prodis.destroy', $prodi);
        return back()->with('status','Prodi dihapus');
    }
}
