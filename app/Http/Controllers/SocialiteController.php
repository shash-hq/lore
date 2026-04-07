<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        if (! $this->googleAuthEnabled()) {
            return redirect('/login')->withErrors(['email' => 'Google sign-in is not configured yet.']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        if (! $this->googleAuthEnabled()) {
            return redirect('/login')->withErrors(['email' => 'Google sign-in is not configured yet.']);
        }

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'username' => 'google_' . substr(md5($googleUser->getId()), 0, 8),
                    'password' => bcrypt(Str::random(24)),
                    'role' => 'viewer',
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Google authorization failed']);
        }
    }

    protected function googleAuthEnabled(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }
}
