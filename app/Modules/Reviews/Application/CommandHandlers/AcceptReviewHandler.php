<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\CommandHandlers;

use App\Modules\Reviews\Domain\Services\ReviewService;
use App\Modules\Reviews\Application\Commands\AcceptReview;

class AcceptReviewHandler
{
    public function __construct(
        private ReviewService $service,
    ){
    }

    public function __invoke(AcceptReview $command): void
    {
        $this->service->acceptReview($command->reviewId);
    }
}
