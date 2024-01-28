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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            $link = match (request()->path()) {
                'foo/forgot-password' => config('foo.reset_password_url') . $token,
                'bar/forgot-password' => config('bar.reset_password_url') . $token,
                default => null
            };
            return $link;
        });
    }
}
