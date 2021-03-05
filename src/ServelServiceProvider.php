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
        $this->mergeConfigFrom($this->configFilePath(), 'servel');
    }

    /**
     * Register the config for publishing
     *
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StartServelCommand::class
            ]);
        }
    }

    /**
     * Get the config filepath.
     *
     * @return string
     */
    protected function configFilePath(): string
    {
        return __DIR__ . '/../config/servel.php';
    }
}
