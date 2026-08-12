<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the Social authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT: To use Socialite, you must first install the package:
        | composer require laravel/socialite
        |--------------------------------------------------------------------------
        */
        
        if (!class_exists('Laravel\Socialite\Facades\Socialite')) {
            return redirect()->back()->with('error', 'Social login is not configured yet. Please install laravel/socialite and add your App/Secret keys.');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the Social Provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Check if user already exists
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Update social ID if missing
                if (!$user->social_id) {
                    $user->update([
                        'social_id' => $socialUser->getId(),
                        'social_type' => $provider,
                    ]);
                }
                
                Auth::login($user, true);
                return redirect()->route('dashboard');
            }

            // Create a new user
            $newUser = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'social_id' => $socialUser->getId(),
                'social_type' => $provider,
                'password' => Hash::make(Str::random(16)), // Dummy password
                // 'type' => 'owner', // Make sure to assign the default role or type!
                // 'lang' => 'en',
            ]);

            Auth::login($newUser, true);
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Social login failed. Error: ' . $e->getMessage());
        }
    }
}
