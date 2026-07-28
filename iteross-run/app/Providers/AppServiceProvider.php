<?php

namespace App\Providers;

use App\Modules\Admin\Domain\HomePageContentRepository;
use App\Modules\Admin\Domain\ProductPageSettingsRepository;
use App\Modules\Admin\Domain\DeliveryPageContentRepository;
use App\Modules\Admin\Domain\HeaderContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageDeliveryPageContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageHeaderContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageHomePageContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageProductPageSettingsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DeliveryPageContentRepository::class, StorageDeliveryPageContentRepository::class);
        $this->app->bind(HeaderContentRepository::class, StorageHeaderContentRepository::class);
        $this->app->bind(HomePageContentRepository::class, StorageHomePageContentRepository::class);
        $this->app->bind(ProductPageSettingsRepository::class, StorageProductPageSettingsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
