<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Prodi;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'prodis' => Prodi::orderBy('nama_prodi')->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle profile photo upload (Breeze-style)
        if ($request->hasFile('photo')) {
            // Ensure the uploaded file is valid before accessing real path
            if (! $request->file('photo')->isValid()) {
                return Redirect::back()->withErrors([
                    'photo' => 'Gagal mengunggah foto. Silakan coba lagi.',
                ]);
            }

            $user = $request->user();
            if ($user->profile_photo_path && \Storage::disk('public')->exists($user->profile_photo_path)) {
                \Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Final attempt: Use Storage::put() directly
            $photo = $request->file('photo');
            $extension = $photo->extension() ?: 'jpg';
            $filename = \Illuminate\Support\Str::random(40) . '.' . $extension;
            $path = 'photos/' . $filename;
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $photo->get());
            $data['profile_photo_path'] = $path;
        }

        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
