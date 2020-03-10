<?php

namespace Mniknab\Surl;

use Illuminate\Support\ServiceProvider;
use Mniknab\Surl\Contracts;

/**
 * Class SurlServiceProvider
 *
 * @package Mniknab\Surl
 * @author MohammadNiknab <MohammadNiknab@gmail.com>
 */
class SurlServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Contracts\Surl::class, Surl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'surl');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'surl');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/surl'),
            ],'views');

            $this->publishes([
                __DIR__.'/../config/surl.php' => config_path('surl.php')
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/surl'),
            ],'translate');

        }
    }
}
