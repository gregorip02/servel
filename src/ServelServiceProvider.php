<?php

namespace Servel;

use Illuminate\Support\ServiceProvider;

class ServelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->packageBasePath('config/servel.php'), 'servel');
    }

    /**
     * Register the config for publishing
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StartServelCommand::class
            ]);

            $this->publishes([
                $this->packageBasePath('config/servel.php') => config_path('servel.php')
            ], 'servel-config');
        }
    }

    /**
     * Get the config filepath.
     *
     * @return string
     */
    protected function packageBasePath(string $path = ''): string
    {
        return __DIR__ . "/../{$path}";
    }
}
