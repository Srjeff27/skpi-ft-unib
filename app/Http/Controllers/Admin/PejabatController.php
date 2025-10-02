<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Official;

class PejabatController extends Controller
{
    public function index(): View
    {
        $officials = Official::orderByDesc('is_active')->orderBy('jabatan')->get();
        return view('admin.pejabat.index', compact('officials'));
    }

    public function create(): View
    {
        return view('admin.pejabat.form', ['official' => new Official()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'gelar_depan' => ['nullable','string','max:255'],
            'gelar_belakang' => ['nullable','string','max:255'],
            'jabatan' => ['required','string','max:255'],
            'nip' => ['nullable','string','max:100'],
            'is_active' => ['nullable','boolean'],
            'signature' => ['nullable','image','max:5120'],
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if ($request->hasFile('signature')) {
            $path = $request->file('signature')->store('signatures', 'public');
            $data['signature_path'] = $path;
        }

        $official = Official::create($data);
        if ($official->is_active) {
            Official::where('id','!=',$official->id)->update(['is_active'=>false]);
        }
        return redirect()->route('admin.pejabat.index')->with('status','Pejabat ditambahkan.');
    }

    public function edit(Official $pejabat): View
    {
        return view('admin.pejabat.form', ['official'=>$pejabat]);
    }

    public function update(Request $request, Official $pejabat)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'gelar_depan' => ['nullable','string','max:255'],
            'gelar_belakang' => ['nullable','string','max:255'],
            'jabatan' => ['required','string','max:255'],
            'nip' => ['nullable','string','max:100'],
            'is_active' => ['nullable','boolean'],
            'signature' => ['nullable','image','max:5120'],
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if ($request->hasFile('signature')) {
            if ($pejabat->signature_path && Storage::disk('public')->exists($pejabat->signature_path)) {
                Storage::disk('public')->delete($pejabat->signature_path);
            }
            $data['signature_path'] = $request->file('signature')->store('signatures','public');
        }

        $pejabat->update($data);
        if ($pejabat->is_active) {
            Official::where('id','!=',$pejabat->id)->update(['is_active'=>false]);
        }
        return redirect()->route('admin.pejabat.index')->with('status','Pejabat diperbarui.');
    }

    public function destroy(Official $pejabat)
    {
        if ($pejabat->signature_path && Storage::disk('public')->exists($pejabat->signature_path)) {
            Storage::disk('public')->delete($pejabat->signature_path);
        }
        $pejabat->delete();
        return back()->with('status','Pejabat dihapus.');
    }
}
