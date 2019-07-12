<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            config_path('site.php'), 'site'
        );


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // config([
        //     'settings' => DB::table('settings')
        //         ->get()
        //         ->keyBy('name') // key every setting by its name
        //         ->transform(function ($setting) {
        //             return $setting->value; // return only the value
        //         })
        //         ->toArray() // make it an array
        // ]);

    }
}
