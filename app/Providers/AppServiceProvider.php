<?php

namespace App\Providers;

use App\Modules\Reviews\Domain\Entity\Review;
use App\Modules\Reviews\Domain\Event\DomainEventPublisherInterface;
use App\Modules\Reviews\Domain\Repository\ReviewRepositoryInterface;
use App\Modules\Reviews\Domain\Service\ReviewService;
use App\Modules\Reviews\Infrastructure\Kafka\ReviewDomainEventPublisher;
use App\Modules\Reviews\Infrastructure\Mysql\DoctrineReviewRepository;
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
        $this->app->singleton(
            ReviewRepositoryInterface::class,
            function ($application) {
                $entityManager = $application->make(EntityManagerInterface::class);

                return new DoctrineReviewRepository(
                    $entityManager,
                    $entityManager->getRepository(Review::class)
                );
            }
        );

        $this->app->singleton(
            DomainEventPublisherInterface::class,
            function ($application) {
                return new ReviewDomainEventPublisher(

                );
            }
        );

        $this->app->singleton(
            ReviewService::class,
            function ($application) {
                return new ReviewService(
                    $application->make(ReviewRepositoryInterface::class),
                    $application->make(DomainEventPublisherInterface::class),
                );
            }
        );
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
