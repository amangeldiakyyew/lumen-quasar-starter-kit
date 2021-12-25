<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $request = app('request');

        // ALLOW OPTIONS METHOD
        if ($request->getMethod() === 'OPTIONS') {
            app()->options($request->path(), function () use ($request) {
                return response('OK', 200);
            });
        }
    }
}
