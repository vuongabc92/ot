<?php

namespace King\Backend;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class BackendServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {

        //Load helpers
        Include_once realpath(__DIR__ . '/support/helpers.php');

        //Load views
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'backend');

        //Load translation
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'backend');

        //Set up routes
        $this->setupRoutes($this->app->router);

        /** Merge config */
        $this->mergeConfigFrom(
            __DIR__ . '/config/backend.php', 'back'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/config/constants.php', 'constant'
        );

        //Publish assets
        $this->publishes([
            __DIR__ . '/../public' => public_path('packages/king/backend'),
        ], 'public');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router) {
        $router->group(['namespace' => 'King\Backend\Http\Controllers'], function($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->registerFrontend();
        config([
            'config/backend.php',
        ]);
    }

    private function registerFrontend() {
        $this->app->bind('backend', function($app) {
            return new Backend($app);
        });
    }

}
