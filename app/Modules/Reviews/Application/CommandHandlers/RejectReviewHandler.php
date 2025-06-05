<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\CommandHandlers;

use App\Modules\Reviews\Domain\Services\ReviewService;
use App\Modules\Reviews\Application\Commands\RejectReview;

class RejectReviewHandler
{
    public function __construct(
        private ReviewService $service,
    ){
    }

    public function __invoke(RejectReview $command): void
    {
        $this->service->rejectReview($command->reviewId);
    }
}
