<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find user by google_id
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // User exists, log them in
                Auth::login($user);
                return redirect()->intended('dashboard');
            }

            // User doesn't exist with google_id, check by email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // User with this email exists, link the google_id
                $user->update(['google_id' => $googleUser->id]);
            } else {
                // No user found, create a new one
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null, // No password when using Google login
                    'role' => 'mahasiswa', // Default role for new users
                ]);
            }

            Auth::login($user);
            return redirect()->intended('dashboard');

        } catch (\Exception $e) {
            // Handle exceptions, maybe redirect to login with an error
            return redirect('/login')->with('error', 'Terjadi kesalahan saat otentikasi dengan Google.');
        }
    }
}
