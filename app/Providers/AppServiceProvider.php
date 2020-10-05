<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Event to send email to user on creating a user
        User::created(function ($user) {
            Mail::to($user)->send(new UserCreated($user));
        });
        User::updated(function ($user) {
            if ($user->isDirty('email')) {
                Mail::to($user)->send(new UserMailChanged($user));
            }
        });
    }
}
