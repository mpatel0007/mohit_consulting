<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Cashier\Cashier;
use App\Models\Cashier\User;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();   
    }    

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Cashier::useCustomerModel(User::class);
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
