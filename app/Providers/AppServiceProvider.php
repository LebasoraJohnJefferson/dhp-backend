<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return 'https://rhu-barugo.vercel.app/resetpassword?token='.$token;
        });
    }
}
