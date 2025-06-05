<?php
declare(strict_types=1);

namespace App\Modules\Reviews\Application\CommandHandlers;

use App\Modules\Reviews\Domain\Entities\Review;
use App\Modules\Reviews\Domain\Services\ReviewService;
use App\Modules\Reviews\Application\Commands\CreateReview;

class CreateReviewHandler
{
    public function __construct(
        private ReviewService $service,
    ){
    }

    public function __invoke(CreateReview $command): Review
    {
        return $this->service->createReview(
            $command->content,
            $command->userId,
            $command->applicationId,
        );
    }
}
