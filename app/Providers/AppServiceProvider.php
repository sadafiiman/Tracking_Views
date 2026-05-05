<?php

namespace App\Providers;

use App\Interfaces\TrackingServiceInterface;
use App\Interfaces\TrackingViewsRepositoryInterface;
use App\Repositories\RedisTrackingViewsRepository;
use App\Services\TrackingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TrackingServiceInterface::class,
            TrackingService::class
        );

        $this->app->bind(
            TrackingViewsRepositoryInterface::class,
            RedisTrackingViewsRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
