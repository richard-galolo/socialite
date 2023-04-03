<?php

namespace WebFuelAgency\Socialite\Tests;

use WebFuelAgency\Socialite\SocialiteServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        include_once __DIR__ . '/../database/migrations/create_users_table.php.stub';
        include_once __DIR__ . '/../database/migrations/add_columns_in_users_table.php.stub';
        include_once __DIR__ . '/../database/migrations/alter_password_in_users_table.php.stub';

        // run the migration's up() method
        (new \CreateUsersTable)->up();
        (new \AddColumnsInUsersTable)->up();
        (new \AlterPasswordInUsersTable)->up();
    }

    protected function getPackageProviders($app)
    {
        return [
            SocialiteServiceProvider::class,
        ];
    }
}