<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CompanyRepository;
use App\Services\CompanyService;
use App\Models\Company;
use App\Repositories\JobRepository;
use App\Services\JobService;
use App\Models\Job;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Models\User;

use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\CompanyServiceInterface;

use App\Interfaces\JobRepositoryInterface;
use App\Interfaces\JobServiceInterface;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Company
        $this->app->singleton(CompanyRepositoryInterface::class, function ($app) {
            return new CompanyRepository(new Company());
        });
        $this->app->singleton(CompanyServiceInterface::class, function ($app) {
            return new CompanyService($app->make(CompanyRepositoryInterface::class));
        });

        // Job
        $this->app->singleton(JobRepositoryInterface::class, function ($app) {
            return new JobRepository(new Job());
        });
        $this->app->singleton(JobServiceInterface::class, function ($app) {
            return new JobService($app->make(JobRepositoryInterface::class));
        });

        // User
        $this->app->singleton(UserRepositoryInterface::class, function ($app) {
            return new UserRepository(new User());
        });
        $this->app->singleton(UserServiceInterface::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
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
