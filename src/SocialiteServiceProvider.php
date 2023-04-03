<?php

namespace WebFuelAgency\Socialite;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\SocialiteServiceProvider as Socialite;
use WebFuelAgency\Socialite\Console\InstallSocialitePackage;

class SocialiteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(Socialite::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/services.php', 'services'
        );
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'socialite');

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/../config/services.php' => config_path('socialite.php'),
            // ], 'config');

            // $this->commands([
            //     InstallSocialitePackage::class
            // ]);

            if (!Schema::hasColumns('users', ['auth_provider', 'auth_provider_id'])) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/add_columns_in_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_add_columns_in_users_table.php.stub'),
                    __DIR__ . '/../database/migrations/alter_password_in_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_alter_password_in_users_table.php.stub'),
                    // you can add any number of migrations here
                ], 'migrations');
            }

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/socialite'),
            ], 'views');
        }
    }
}