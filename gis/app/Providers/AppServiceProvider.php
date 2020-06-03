<?php

namespace Gis\Providers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../vendor/almasaeed2010/adminlte/dist' => public_path('vendor/adminlte'),
        ], 'public');

        Validator::extend('upload_count', function($attribute, $value, $parameters)
        {
            $files = Input::file($parameters[0]);

            return (count($files) <= $parameters[1]) ? true : false;
        });

        Schema::defaultStringLength(250);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
