<?php

namespace App\Providers;

use App\Modules\Admin\Application\UseCases\ApplyMailServerSettings;
use App\Modules\Admin\Domain\HomePageContentRepository;
use App\Modules\Admin\Domain\MailServerSettingsRepository;
use App\Modules\Admin\Domain\ProductPageSettingsRepository;
use App\Modules\Admin\Domain\DeliveryPageContentRepository;
use App\Modules\Admin\Domain\HeaderContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageDeliveryPageContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageHeaderContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageHomePageContentRepository;
use App\Modules\Admin\Infrastructure\Persistence\StorageMailServerSettingsRepository;
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
        $this->app->bind(MailServerSettingsRepository::class, StorageMailServerSettingsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $settings = $this->app->make(MailServerSettingsRepository::class)->get();
            $this->app->make(ApplyMailServerSettings::class)->handle($settings);
        } catch (\Throwable) {
            // Storage may be unavailable during early bootstrap (e.g. console commands); ignore.
        }
    }
}
