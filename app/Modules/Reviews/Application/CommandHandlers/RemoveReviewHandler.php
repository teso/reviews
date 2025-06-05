<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\CommandHandlers;

use App\Modules\Reviews\Application\Commands\RemoveReview;
use App\Modules\Reviews\Domain\Services\ReviewService;

class RemoveReviewHandler
{
    public function __construct(
        private ReviewService $service,
    ){
    }

    public function __invoke(RemoveReview $command): void
    {
        $this->service->removeReview($command->reviewId);
    }
}
