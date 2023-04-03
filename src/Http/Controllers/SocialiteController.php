<?php

namespace WebFuelAgency\Socialite\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use WebFuelAgency\Socialite\Tests\User;

class SocialiteController extends Controller
{
    public function index()
    {
        return view('socialite::index');
    }

    /**
     * Redirect User to Provider to approve OAuth Handshake.
     * @return Redirect
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle Return Request from Provider OAuth API
     * @return Redirect
     */
    public function handle($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();

            $user = User::where('auth_provider_id', $providerUser->id)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail() ?? 'no_email',
                    'auth_provider' => $provider,
                    'auth_provider_id' => $providerUser->id,
                ]);
            }

            auth()->login($user, true);

            return redirect(config('socialite.redirect', '/home'));
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with('error', $exception->getMessage());
        }
    }
}
