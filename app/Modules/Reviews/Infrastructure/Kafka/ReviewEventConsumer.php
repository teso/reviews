<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Infrastructure\Kafka;

use App\Modules\Reviews\Domain\Service\ReviewService;

class ReviewEventConsumer
{
    private $reviewService;

    public function __construct(
        ReviewService $reviewService
    ) {
        $this->reviewService = $reviewService;
    }


}
