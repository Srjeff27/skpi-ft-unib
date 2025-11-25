<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Services\ActivityLogger;

class VerifikatorController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->where('role','verifikator')->with('prodi');
        if ($request->filled('prodi_id')) $query->where('prodi_id', $request->integer('prodi_id'));
        $verifikators = $query->orderBy('name')->paginate(20)->withQueryString();
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.verifikators.index', compact('verifikators','prodis'));
    }

    public function create(): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.verifikators.form', ['verifikator' => new User(['role'=>'verifikator']), 'prodis'=>$prodis]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:8'],
            'prodi_id' => ['nullable','exists:prodis,id'],
            'avatar' => ['nullable','in:mahasiswa_male,mahasiswa_female,dosen,verifikator,admin'],
        ]);
        $data['role'] = 'verifikator';
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.verifikators.index')->with('status','Verifikator dibuat');
    }

    public function edit(User $verifikator): View
    {
        abort_unless($verifikator->role==='verifikator', 404);
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.verifikators.form', compact('verifikator','prodis'));
    }

    public function update(Request $request, User $verifikator): RedirectResponse
    {
        abort_unless($verifikator->role==='verifikator', 404);
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$verifikator->id],
            'password' => ['nullable','min:8'],
            'prodi_id' => ['nullable','exists:prodis,id'],
            'avatar' => ['nullable','in:mahasiswa_male,mahasiswa_female,dosen,verifikator,admin'],
        ]);
        if (!empty($data['password'])) $data['password'] = Hash::make($data['password']); else unset($data['password']);
        $data['role'] = 'verifikator';
        $verifikator->update($data);
        return redirect()->route('admin.verifikators.index')->with('status','Verifikator diperbarui');
    }

    public function destroy(Request $request, User $verifikator): RedirectResponse
    {
        abort_unless($verifikator->role==='verifikator', 404);
        $verifikator->delete();
        ActivityLogger::log($request->user(), 'admin.verifikators.destroy', $verifikator);
        return back()->with('status','Verifikator dihapus');
    }
}
