<?php

namespace WebFuelAgency\Socialite\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use WebFuelAgency\Socialite\Tests\User;

class SocialiteController extends Controller
{
    public function index()
    {
        return view('socialite::index');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
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

            Auth::login($user, true);

            return redirect('/home');
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with('error', $exception->getMessage());
        }
    }
}
