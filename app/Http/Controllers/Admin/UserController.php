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

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->with('prodi');
        if ($request->filled('role')) $query->where('role', $request->string('role'));

        $users = $query->orderBy('name')->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.users.form', ['user' => new User(), 'prodis' => $prodis]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:8'],
            'role' => ['required','in:admin,verifikator,mahasiswa'],
            'nim' => ['nullable','string','max:50'],
            'angkatan' => ['nullable','integer'],
            'prodi_id' => ['nullable','exists:prodis,id'],
            'avatar' => ['nullable','in:mahasiswa_male,mahasiswa_female,dosen,verifikator,admin'],
        ]);
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        ActivityLogger::log($request->user(), 'admin.users.store');
        return redirect()->route('admin.users.index')->with('status','User dibuat');
    }

    public function edit(User $user): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.users.form', compact('user','prodis'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
            'role' => ['required','in:admin,verifikator,mahasiswa'],
            'nim' => ['nullable','string','max:50'],
            'angkatan' => ['nullable','integer'],
            'prodi_id' => ['nullable','exists:prodis,id'],
            'password' => ['nullable','min:8'],
            'avatar' => ['nullable','in:mahasiswa_male,mahasiswa_female,dosen,verifikator,admin'],
        ]);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        ActivityLogger::log($request->user(), 'admin.users.update', $user);
        return redirect()->route('admin.users.index')->with('status','User diperbarui');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        ActivityLogger::log($request->user(), 'admin.users.destroy', $user);
        return back()->with('status','User dihapus');
    }

    public function resetPassword(User $user): RedirectResponse
    {
        $user->update(['password' => Hash::make('password123')]);
        ActivityLogger::log($request->user(), 'admin.users.reset_password', $user);
        return back()->with('status','Password direset menjadi password123');
    }
}
