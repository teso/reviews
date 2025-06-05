<?php

namespace App\Providers;

use App\Modules\Reviews\Domain\Entities\Review;
use App\Modules\Reviews\Domain\Events\DomainEventPublisherInterface;
use App\Modules\Reviews\Domain\Repositories\ReviewRepositoryInterface;
use App\Modules\Reviews\Domain\Services\ReviewService;
use App\Modules\Reviews\Infrastructure\Kafka\ReviewDomainEventPublisher;
use App\Modules\Reviews\Infrastructure\Doctrine\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepository::class,
        );

        $this->app->bind(
            DomainEventPublisherInterface::class,
            ReviewDomainEventPublisher::class,
        );

        $this->app->singleton(ReviewService::class);
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
