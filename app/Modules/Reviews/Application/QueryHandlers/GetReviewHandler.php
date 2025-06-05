<?php

declare(strict_types=1);

namespace App\Modules\Reviews\Application\QueryHandlers;

use App\Modules\Reviews\Application\Queries\GetReview;
use App\Modules\Reviews\Domain\Entities\Review;
use App\Modules\Reviews\Domain\Services\ReviewService;

class GetReviewHandler
{
    public function __construct(
        private ReviewService $service,
    ){
    }

    public function __invoke(GetReview $query): ?Review
    {
        $review = $this->service->getReview($query->reviewId);

        return $review;
    }
}
