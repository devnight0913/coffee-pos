<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Schema::defaultStringLength(190);

        $this->canEditDirective();
        $this->canDeleteDirective();

        $settings = Settings::getValues();
        $lang = $settings->lang;
        $cssUrl = $lang == "ar" ? asset('css/app.rtl.css') : mix('css/app.css');
        App::setLocale($lang);
        Config::set('settings', $settings);

        View::share([
            'settings' =>  $settings,
            'cssUrl' => $cssUrl,
        ]);
    }



    protected function canEditDirective()
    {
        Blade::if('can_edit', function () {
            return auth()->check() && auth()->user()->can_edit;
        });
    }
    protected function canDeleteDirective()
    {
        Blade::if('can_delete', function () {
            return auth()->check() && auth()->user()->can_delete;
        });
    }
}
