<?php

namespace YTokarchukova\Badge;

use Illuminate\Support\ServiceProvider;
use YTokarchukova\Badge\Console\Commands\BadgesToQueue;

class BadgeServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ytokarchukova');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ytokarchukova');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../config/badge.php', 'badge');

        // Register the service the package provides.
        $this->app->singleton('badge', function($app) {
            return new Badge;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return ['badge'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole() {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/badge.php' => config_path('badge.php'),
        ], 'badge.config');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/ytokarchukova'),
        ], 'badge.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ytokarchukova'),
        ], 'badge.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ytokarchukova'),
        ], 'badge.views');*/

        // Registering package commands.
        $this->commands([
            BadgesToQueue::class,
        ]);
    }
}
