<?php

namespace App\Providers;

use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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

        $this->app->singleton(TwilioService::class, function ($app) {
            /**
             * @var User $user
             */
            $user = Auth::user();
            return new TwilioService(
                $user->company->companyTwilioSettings->sid,
                $user->company->companyTwilioSettings->token,
            );
        });
    }
}
