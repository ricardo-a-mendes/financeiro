<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
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
		Validator::extend('combo', function ($attribute, $value, $parameters, $validator){
			if (is_array($parameters) && isset($parameters[0]))
				return ($value !== 'invalid_option');
			return false;
		});
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
