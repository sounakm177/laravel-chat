<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\{
   UserRepository
};

use App\Repositories\Interfaces\{
   UserRepositoryInterface
};


class RepositoryServiceProvider extends ServiceProvider
{

    public array $bindings = [
       UserRepositoryInterface::class => UserRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
