<?php

namespace App\Providers;

use App\Modules\Admin\Domain\HomePageContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageHomePageContentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HomePageContentRepository::class, StorageHomePageContentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
