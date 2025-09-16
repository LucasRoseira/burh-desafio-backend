<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CompanyRepository;
use App\Services\CompanyService;
use App\Models\Company;

use App\Repositories\JobRepository;
use App\Services\JobService;
use App\Models\Job;

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

        $this->app->singleton(JobRepository::class, function ($app) {
            return new JobRepository(new Job());
        });

        $this->app->singleton(JobService::class, function ($app) {
            return new JobService($app->make(JobRepository::class));
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
