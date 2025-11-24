<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(['id', 'nama_prodi']);
        return view('auth.register', compact('prodis'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npm' => ['required', 'string', 'max:25', 'unique:users,nim'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $npm = strtoupper(trim($request->npm));

        $user = User::create([
            'name' => $request->name,
            'nim' => $npm,
            'prodi_id' => $request->prodi_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // pastikan akun yang registrasi via Breeze adalah mahasiswa
            'role' => 'mahasiswa',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
