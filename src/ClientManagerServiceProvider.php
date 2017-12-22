<?php

namespace Pila\ClientManager;

use Illuminate\Support\ServiceProvider;

class ClientManagerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }

        $this->loadViewsFrom(base_path('resources/views'), 'clientmanager');
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/pila/client'),
        ]);

        $this->publishes([
            __DIR__ . '/public' => public_path('assets/pila/client'),
        ]);

        $this->publishes([
            __DIR__ . '/clients' => resource_path('/pila/client'),
        ]);

        $this->loadTranslationsFrom(resource_path('/pila/lang'), 'clientmanager');
        $this->publishes([
            __DIR__ . '/lang' => resource_path('/pila/lang'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('\Wilgucki\Csv\CsvServiceProvider');
    }
}