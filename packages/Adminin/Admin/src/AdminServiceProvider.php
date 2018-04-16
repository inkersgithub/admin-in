<?php

namespace Adminin\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/Http/routes.php';

        $this->loadViewsFrom(__DIR__ . '/views','Admin');

        $this->publishes([
        __DIR__.'/views' => base_path('resources/views/Adminin/Admin'),
        ]);

        app()->router->middleware('admin', \Adminin\Admin\Http\Middleware\AdminMiddleware::class);
        app('router')->aliasMiddleware('admin',\Adminin\Admin\Http\Middleware\AdminMiddleware::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('admin', function ($app) {
            return new Admin;
        });
    }
}
