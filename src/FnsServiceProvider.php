<?php

namespace LevinPwnz\FnsCheck;

use Illuminate\Support\ServiceProvider;

/**
 * Class FnsServiceProvider
 * @package LevinPwnz\FnsCheck
 */
class FnsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register()
    {
        $this->publishes([__DIR__ . '/config/fnsconfig.php' => config_path('fnsconfig.php')], 'config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
