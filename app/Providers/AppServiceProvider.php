<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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

        Route::bind('company_hash', function ($value) {
            return Company::query()->where('hash', $value)->firstOrFail();
        });

        Paginator::useBootstrap();
        $this->app->singleton(TwilioService::class, function ($app) {
            /**
             * @var User $user
             */
            $user = Auth::user();
            if(!$user){
                $request = $app->make(Request::class);
                $company = $request->route('company_hash');
                if(!$company)
                {
                    throw new \Exception('Company not found');
                }
            }else{
                $company = $user->company;
            }
            return new TwilioService(
                $company->companyTwilioSettings->sid,
                $company->companyTwilioSettings->token,
            );
        });
    }
}
