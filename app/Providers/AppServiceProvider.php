<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
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
            if(!$user){
                $request = $app->make(Request::class);
                $hash = $request->route('company_hash'); // Get company_name from the route
                $company = Company::query()->where('hash', $hash)->first();
                if(!$company){
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
