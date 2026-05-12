<?php

namespace VitalSaaS\VitalCMSMinimal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class VitalCMSMinimalServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/vitalcms.php', 'vitalcms'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrations();
        $this->publishConfiguration();
        $this->loadRoutes();
        $this->registerCommands();
    }

    /**
     * Load package migrations.
     */
    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Publish configuration file.
     */
    protected function publishConfiguration(): void
    {
        $this->publishes([
            __DIR__ . '/../config/vitalcms.php' => config_path('vitalcms.php'),
        ], 'vitalcms-config');
    }

    /**
     * Load package routes.
     */
    protected function loadRoutes(): void
    {
        Route::group([
            'prefix' => 'api',
            'middleware' => ['api'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    /**
     * Register Artisan commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallVitalCMSMinimalCommand::class,
            ]);
        }
    }
}