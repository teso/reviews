<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Kafka;

class ReviewEventConsumer
{
    public function __construct(
        private ReviewService $reviewService,
    ) {
    }
}
