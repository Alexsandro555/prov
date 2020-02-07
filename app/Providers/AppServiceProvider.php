<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Entities\TypeProduct;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer('layouts.master', function($view) {
        $view->with('typeProducts',TypeProduct::has('productCategory')->with('productCategory')->take(21)->get());
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton(FakerGenerator::class, function () {
        return FakerFactory::create('ru_RU');
      });
    }
}
