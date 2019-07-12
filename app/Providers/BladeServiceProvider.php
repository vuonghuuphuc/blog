<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    protected $scriptUrls = [];
    protected $styleUrls = [];

    public function boot()
    {
        //Include script to blade template
        Blade::directive('script', function ($link) {

           

            //Check link already include or not
            if(!array_key_exists($link, $this->scriptUrls)){
                //not include yet
                $this->scriptUrls[$link] = true;
                return "<script src='<?php echo {$link}; ?>'></script>";
            }
        });

        //Include script to blade template
        Blade::directive('style', function ($link) {


            //Check link already include or not
            if(!array_key_exists($link, $this->styleUrls)){
                //not include yet
                $this->styleUrls[$link] = true;
                return "<link href='<?php echo {$link}; ?>' rel='stylesheet'>";
            }
        });
    }
}
