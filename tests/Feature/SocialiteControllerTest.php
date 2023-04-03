<?php

namespace WebFuelAgency\Socialite\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as Socialite;
use WebFuelAgency\Socialite\Tests\TestCase;
use WebFuelAgency\Socialite\Tests\User;

class SocialiteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRedirectToProvider()
    {
        $provider = 'google';

        // Mock the Socialite facade
        Socialite::shouldReceive('driver')->with($provider)->andReturnSelf();
        Socialite::shouldReceive('redirect')->andReturn(redirect('/auth/google/callback'));

        $response = $this->get("/auth/{$provider}");

        $response->assertStatus(302);
        $response->assertRedirect('/auth/google/callback');

        $redirectUrl = $response->headers->get('location');

        $this->assertStringContainsString($provider, $redirectUrl);
    }

    public function testHandleProviderCallback()
    {
        $provider = 'google';

        // Mock the Socialite facade
        $providerUser = new \stdClass();
        $providerUser->id = '123';
        $providerUser->name = 'John Doe';
        $providerUser->email = 'johndoe@example.com';
        Socialite::shouldReceive('driver')->with($provider)->andReturnSelf();
        Socialite::shouldReceive('stateless')->andReturnSelf();
        Socialite::shouldReceive('user')->andReturn($providerUser);

        // Mock the User model
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';
        $user->email = 'johndoe@example.com';
        $user->auth_provider = $provider;
        $user->auth_provider_id = '123';
        $user->save();

        // Auth::shouldReceive('login')->with($user, true);

        $response = $this->get("/auth/{$provider}/callback");

        $response->assertStatus(302);
        $response->assertRedirect('/home');
    }
}
