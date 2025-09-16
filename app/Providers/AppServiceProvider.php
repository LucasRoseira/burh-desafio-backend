<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CompanyRepository;
use App\Models\Company;
use App\Services\CompanyService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(CompanyRepository::class, function ($app) {
            return new CompanyRepository(new Company());
        });

        $this->app->singleton(CompanyService::class, function ($app) {
            return new CompanyService($app->make(CompanyRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
