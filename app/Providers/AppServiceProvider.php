<?php

namespace App\Providers;

use App\Services\DatabaseServices;
use App\Interfaces\DatabaseInterface;
use App\Repositories\MariadbRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\FirebaseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $databaseType = config('database.holdemdb');

        if ($databaseType === 'firebase') {
            $this->app->bind(DatabaseInterface::class, FirebaseRepository::class);
        } elseif ($databaseType === 'mariadb') {
            $this->app->bind(DatabaseInterface::class, MariadbRepository::class);
        } else {
            throw new \Exception("Unsupported database type: $databaseType");
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
