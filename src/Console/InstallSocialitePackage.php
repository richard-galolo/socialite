<?php

namespace WebFuelAgency\Socialite\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallSocialitePackage extends Command
{
    protected $signature = 'socialite:install';

    protected $description = 'Install the Socialite Package';

    public function handle()
    {
        $this->info('Installing Socialite...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('socialite.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed Socialite');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "WebFuelAgency\Socialite\SocialiteServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

       $this->call('vendor:publish', $params);
    }
}